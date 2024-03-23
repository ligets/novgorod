<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use App\Models\AlbumResource;
use App\Models\UserAlbum;
use App\Models\Album;
use Illuminate\Support\Facades\Auth;

class MediaController extends Controller
{
    public function publicMedia(){
        $photos = Resource::where('type_id', 1)
                            ->where('format', 'image')
                            ->where('in_album', false)
                            ->inRandomOrder()
                            ->limit(10)
                            ->get();
        $movies = Resource::where('type_id', 1)
                            ->where('format', 'video')
                            ->where('in_album', false)
                            ->inRandomOrder()
                            ->limit(10)
                            ->get();
        $albums = Album::where('type_id', 1)
                            ->inRandomOrder()
                            ->limit(10)
                            ->get();
        return view('home', compact('photos', 'movies', 'albums'));
    }

    public static function albumMedia($id){
    //     $album_resources = AlbumResource::where('album_id', $id)->get();
    //     // return $album_resources->resource;
    //     $media = [];
    //     foreach($album_resources as $resource){
    //         $media[] = $resource->resource;
    //     }
    //     return view('media', compact('media'));
        $album = Album::where('id', $id)->first();
        $authors = UserAlbum::where('album_id', $id)->whereNot('role', 'owner')->get();
        $albumResources = AlbumResource::where('album_id', $id)
            ->with('resource') // Загрузка связанных ресурсов
            ->get()
            ->groupBy(function ($albumResource) {
                return $albumResource->resource->format; // Группировка по формату
            });
        $role = UserAlbum::where('user_id', Auth::user()->id)->where('album_id', $id)->first()->role;
        $images = $albumResources->get('image', collect()); // Получение массива ресурсов изображений
        $videos = $albumResources->get('video', collect()); // Получение массива ресурсов видео
        return view('media', compact('images', 'videos', 'album', 'authors', 'role'));
    }
}
