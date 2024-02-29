<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
// use Illuminate\Validation\ValidationException;
use App\Rules\ImageOrVideo;
use App\Models\Resource;
use App\Models\AlbumResource;
use App\Models\Album;
use App\Models\UserAlbum;
// use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        if(isset($request->in_album)){
            $in_album = $request->in_album;
        }
        $type = $request->type;

        // receive the file
        $save = $receiver->receive();

        // check if the upload has finished (in chunk mode it will send smaller files)
        if ($save->isFinished()) {
            // save the file and return any response you need, current example uses `move` function. If you are
            // not using move, you need to manually delete the file by unlink($save->getFile()->getPathname())
            return $this->saveFile($save->getFile(), $in_album, $type);
        }

        // we are in chunk mode, lets send the current progress
        $handler = $save->handler();

        return response()->json([
            "done" => $handler->getPercentageDone(),
            'status' => true
        ]);
    }

    /**
     * Saves the file
     *
     * @param UploadedFile $file
     *
     * @return JsonResponse
     */
    protected function saveFile(UploadedFile $file, $in_album, $type)
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

        // Group files by mime type
        $mime = str_replace('/', '-', $file->getMimeType());

        // Group files by the date (week
        $dateFolder = date("Y-m-W");

        // Build the file path
        $filePath = "upload/{$mime}/{$dateFolder}";
        $finalPath = storage_path("app/public/" . $filePath);

        // move the file name
        $file->move($finalPath, $fileName);

        $fileFormat = $this->detectFileFormat($file);

        // $resource = new Resource();
        // $resource->user_id = Auth::user()->id;
        // $resource->path = $filePath . '/' . $fileName;
        // $resource->format = $fileFormat;
        // if($in_album){
        //     $resource->in_album = true;
        // }
        // $resource->type_id = $type;
        // $resource->save();
        $resource_id = Resource::create([
            'user_id' => Auth::user()->id,
            'path' => $filePath . '/' . $fileName,
            'format' => $fileFormat,
            'in_album' => $in_album ? true : false,
            'type_id' => $type
        ])->id;
        if($in_album){
            AlbumResource::create([
                'user_id' => Auth::user()->id,
                'album_id' => $in_album,
                'resource_id' => $resource_id
            ]);
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
        $type = $resource->type()->first()->name;

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
        $type = $album->type()->first()->name;

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

        $zip->close();

        return response()->download($zipFileName)->deleteFileAfterSend(true);
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
}
