<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
// use Illuminate\Validation\ValidationException;
use App\Rules\ImageOrVideo;
use App\Models\Resource;
use App\Models\AlbumResource;
use App\Models\Album;
use App\Models\UserAlbum;
use App\Models\Tag;
use App\Models\Metadata;
use App\Http\Controllers\PyController;
// use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Http;

use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Exceptions\UploadFailedException;

use ZipArchive;

class ResourcesController extends Controller
{
    public function store(Request $request)
    {
        // create the file receiver
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

        // check if the upload is success, throw exception or return response you need
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }
        $in_album = false;
        if($request->in_album !== 'null'){
            $in_album = $request->in_album;
        }        

        // receive the file
        $save = $receiver->receive();

        // check if the upload has finished (in chunk mode it will send smaller files)
        if ($save->isFinished()) {
            $type = $request->type;

            $tags = $request->tags;
            // save the file and return any response you need, current example uses `move` function. If you are
            // not using move, you need to manually delete the file by unlink($save->getFile()->getPathname())
            return $this->saveFile($save->getFile(), $in_album, $type, $tags, $request->title);
        }

        // we are in chunk mode, lets send the current progress
        $handler = $save->handler();

        return response()->json([
            "done" => $handler->getPercentageDone(),
            'status' => true
        ]);
    }

    public function delete(Request $req){

    }

    /**
     * Saves the file
     *
     * @param UploadedFile $file
     *
     * @return JsonResponse
     */
    protected function saveFile(UploadedFile $file, $in_album, $type, $tags, $title)
    {
        $validator = Validator::make(
            ['file' => $file],
            ['file' => ['required', 'file', new ImageOrVideo]], // пример для изображений (JPEG, PNG) и видео (MP4)
            [
                'file.required' => 'Необходимо загрузить файл.',
                'file.file' => 'Загруженный файл некорректен.',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $fileName = $this->createFilename($file);

        $mime = str_replace('/', '-', $file->getMimeType());

        $dateFolder = date("Y-m-W");

        $filePath = "upload/{$mime}/{$dateFolder}";
        $finalPath = storage_path("app/public/" . $filePath);

        $file->move($finalPath, $fileName);

        $fileFormat = $this->detectFileFormat($file);
        
        $fullPath = Storage::disk('public')->path($filePath . '/' . $fileName);
        $file = new \Illuminate\Http\UploadedFile($fullPath, $fileName);
        $metadata = null;

        if ($file && $file->getMimeType() === 'image/jpeg') {
            // Читаем данные EXIF из изображения
            $exifData = exif_read_data($file->getPathname());

            // Проверяем, есть ли данные GPS
            if (isset($exifData['GPSLatitude']) && isset($exifData['GPSLongitude'])) {
                // Сохраняем фото в базу данных

                $latitude = $this->convertToDegrees($exifData['GPSLatitude']);
                $longitude = $this->convertToDegrees($exifData['GPSLongitude']);

                $address = $this->reverseGeocode($latitude, $longitude);
                $city = $address['city'] ?? null;
                $road = $address['road'] ?? null;
                $house_number = $address['house_number'] ?? null;
                $full_adr = $road . ' ' . $house_number;

                // Сохраняем метаданные в базу данных
                $metadata = new Metadata();
                $metadata->device_name = $exifData['Make'] ?? null;
                $metadata->gps_latitude = $latitude;
                $metadata->gps_longitude = $longitude;
                $metadata->city = $city;
                $metadata->road = $full_adr;
                $metadata->save();

                // Выводим HTML с картой и ссылкой
            }
            
        }

        $resourceData = [
            'user_id' => Auth::user()->id,
            'title' => $title, // Предполагается, что переменная $title определена
            'path' => $filePath . '/' . $fileName,
            'format' => $fileFormat,
            'in_album' => $in_album ? true : false,
            'type_id' => $type,
        ];
        
        if ($metadata) {
            $resourceData['metadata_id'] = $metadata->id;
        }
        
        $resource = Resource::create($resourceData);
        $tags = json_decode($tags);
        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate([
                'name' => $tagName
            ]);
            $resource->tags()->attach($tag->id, ['resource_id' => $resource->id]);
        }

        if($in_album){
            AlbumResource::create([
                'user_id' => Auth::user()->id,
                'album_id' => $in_album,
                'resource_id' => $resource->id
            ]);
        }

        if($this->checkAI($mime)){
            PyController::objectDetection($resource->id);
        }
        return response()->json([
            'path' => asset('storage/' . $filePath),
            'name' => $fileName,
            'mime_type' => $mime
        ]);
    }

    /**
     * Create unique filename for uploaded file
     * @param UploadedFile $file
     * @return string
     */
    protected function createFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        // Генерируем уникальное имя файла без использования оригинального имени
        $filename = md5(uniqid()) . "." . $extension;

        return $filename;
    }

    protected function checkAI($mimeType){
        $array = ['image-gif', 'image-jpeg', 'image-png'];
        if(in_array($mimeType, $array)){
            return true;
        }
        return false;
    }

    /**
     * Определение типа файла (изображение или видео).
     *
     * @param UploadedFile $file
     * @return string
     */
    protected function detectFileFormat(UploadedFile $file)
    {
        $allowedImageFormats = ['crw', 'cr2', 'nef', 'nrw', 'arw', 'rw2', 'orf', 'raf', 'dcr', 'srw', 'rwl', 'mos', 'png', 'jpeg', 'jpg', 'gif', 'webp', 'bmp', 'ico', 'dng']; // Ваши форматы изображений
        $allowedVideoFormats = ['mp4', 'ogv', 'webm', 'avi', 'mpeg', 'mpg', 'mov', 'wmv']; // Ваши форматы видео

        $extension = strtolower($file->getClientOriginalExtension());

        if (in_array($extension, $allowedImageFormats)) {
            return 'image';
        } elseif (in_array($extension, $allowedVideoFormats)) {
            return 'video';
        } else {
            return 'other';
        }
    }
    // УСТАНОВКА ИДЁТ ПО ССЫЛКЕ
    public function download($type, $id){
        switch($type){
            case 'resource':
                return $this->downloadResource($id);
                break;
            case 'album':
                return $this->downloadAlbum($id);
                break;
            default:
                abort(404, 'Страницы не найдена');
        }
    }
    
    protected function downloadResource($id){
        $resource = Resource::findOrFail($id);
        $type = $resource->type->name;

        switch($type){
            case 'public':
                break;
            case 'group':
            case 'private':
                if (!Auth::check()) {
                    return redirect(route('login'));
                }
                $this->{$type . 'Resource'}($resource);
                break;
            default:
                abort(404, 'Ресурс не найден');
        }
        if(Storage::disk('public')->exists($resource->path)){
            return Storage::disk('public')->download($resource->path);
            
        }
    }

    protected function downloadAlbum($id){
        $album = Album::findOrFail($id);
        $type = $album->type->name;

        switch($type){
            case 'public':
                break;
            case 'group':
            case 'private':
                // Проверка аутентификации
                if (!Auth::check()) {
                    return redirect(route('login'));
                }
                // Вызов соответствующего метода в зависимости от типа альбома
                $this->{$type}($album);
                break;
            default:
                abort(404, 'Альбом не найден');
        }

        $zipFileName = $album->title . '.zip';
        $zip = new ZipArchive();
        if (!$zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            return response()->json(['message' => 'Не удалось создать zip-архив'], 500);
        }
        $albumResources = AlbumResource::where('album_id', $album->id)->get();
        foreach($albumResources as $albumResource){
            $resource = $albumResource->resource()->first();

            if(Storage::disk('public')->exists($resource->path)){
                $filePath = Storage::disk('public')->path($resource->path);
                $relativePath = basename($resource->path);

                $zip->addFile($filePath, $relativePath);
            }
        }
        $zipFileName = $zip->filename;
        // return $zipFileName;
        $zip->close();
        if (file_exists($zipFileName)) {
            // Возвращаем архив для скачивания
            return response()->download($zipFileName)->deleteFileAfterSend(true);
        } else {
            // Если архив не был создан, возвращаем сообщение об ошибке
            return response()->json(['message' => 'Альбом пуст'], 500);
        }
    }

    protected function private($album){
        if(!$album->authors()->where('role', 'owner')->where('user_id', Auth::user()->id)->exists()){
            abort(403, 'Доступ запрещён');
        }
    }
    protected function group($album){
        if (!$album->authors()->where('user_id', Auth::user()->id)->exists()) {
            abort(403, 'Доступ запрещён');
        }
    }
    protected function groupResource($resource){
        $album_id = AlbumResource::where('resource_id', $resource->id)->first()->album_id;
        if(!UserAlbum::where('album_id', $album_id)->where('user_id', Auth::user()->id)->exists()){
            abort(403, 'Доступ запрещён');
        }
    }
    protected function privateResource($resource){
        if($resource->user_id !== Auth::user()->id){
            abort(403, 'Доступ запрещён');
        }
    }



    protected function convertToDegrees($coordinates) {
        $degrees = (double) $coordinates[0];
        $minutes = isset($coordinates[1]) ? (double) $coordinates[1] : 0;
        $seconds_numerator = isset($coordinates[2]) ? (double) $coordinates[2] : 0;

        // Проверяем, является ли числитель числом
        if (is_numeric($seconds_numerator)) {
            // Если третий элемент массива представлен в виде числитель/знаменатель, вычисляем значение секунд
            if (strpos($seconds_numerator, '/') !== false) {
                list($numerator, $denominator) = explode('/', $seconds_numerator);
                $seconds = $numerator / $denominator;
            } else {
                $seconds = $seconds_numerator;
            }
        } else {
            // Если значение не числовое, устанавливаем секунды как 0
            $seconds = 0;
        }

        $resigned = $degrees + $minutes / 60 + $seconds / 3600 /1000000;
        return $resigned;
    }

    public function reverseGeocode($latitude, $longitude)
    {
        $url = "https://nominatim.openstreetmap.org/reverse?lat=$latitude&lon=$longitude&format=json&zoom=18&addressdetails=1";
        $response = Http::get($url);
        $data = $response->json();
        // Получите адрес из ответа и верните его
        $address = $data['address'] ?? null;
        return $address;
    }
}
