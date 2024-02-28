<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Album;
use App\Models\UserAlbum;
use Carbon\Carbon;
use App\Http\Controllers\MediaController;

class AlbumsController extends Controller {
    public function create(Request $req) {

        // Сделать обработку ТИПА альбома

        $req->validate([
            'title' => 'required|string|max:20',
            'description' => 'string| max:255',
        ], [
            'title.required' => 'Поле названия обязательно для заполнения.',
            'title.string' => 'Поле названия должно быть строкой.',
            'title.max' => 'Поле названия не должно превышать :max символов.',

            'description.string' => 'Поле описания должно быть строкой.',
            'description.max' => 'Поле описания не должно превышать :max символов.'
        ]);
        $id = Auth::user()->id;

        $album = Album::create([
            'title' => $req->title,
            'description' => $req->description,
            'type_id' => $type_id,
        ]);
        UserAlbum::create([
            'user_id' => $id,
            'album_id' => $album->id,
            'role' => 'owner'
        ]);
    }

    public function edit_authors(Request $req, $id){
        // $authors = $req->authors;
        $authors = [2, 3];
        UserAlbum::whereNotIn('user_id', $authors)
            ->where('role', 'author')
            ->where('album_id', $id)
            ->delete();

        $existingAuthors = UserAlbum::where('role', 'author')
            ->where('album_id', $id)
            ->pluck('user_id') // Получаем массив всех идентификаторов авторов альбома
            ->toArray();

        $authorsToAdd = array_diff($authors, $existingAuthors); // Находим идентификаторы авторов, которых еще нет в списке


        $dataToInsert = [];

        $time = Carbon::now()->timezone('Europe/Moscow')->toDateTimeString();
        // Создаем новые записи для каждого автора, которого еще нет в списке
        foreach ($authorsToAdd as $authorId) {
            $dataToInsert[] = [
                'user_id' => $authorId,
                'album_id' => $id,
                'role' => 'author',
                'created_at' => $time, // Предположим, что нужно указать временные метки
                'updated_at' => $time
            ];
        }
        
        if (!empty($dataToInsert)) {
            UserAlbum::insert($dataToInsert);
        }
    }

    public function get($id){
        $album = Album::findOrFail($id);
        $type = $album->type()->first()->name;
        switch($type){
            case 'public':
                return MediaController::albumMedia($album->id);
                break;
            case 'group':
            case 'private':
                // Проверка аутентификации
                if (!Auth::check()) {
                    return redirect(route('login'));
                }
                // Вызов соответствующего метода в зависимости от типа альбома
                return $this->{$type}($album);
            default:
                abort(404, 'Альбом не найден');
        }
    }

    protected function private($album){
        if(!$album->authors()->where('role', 'owner')->where('user_id', Auth::user()->id)->exists()){
            abort(403, 'Доступ запрещён');
        }
        return MediaController::albumMedia($album->id);
    }
    protected function group($album){
        if (!$album->authors()->where('user_id', Auth::user()->id)->exists()) {
            abort(403, 'Доступ запрещён');
        }
        return MediaController::albumMedia($album->id);
    }
}
