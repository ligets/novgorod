<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use App\Models\AlbumResource;
use App\Models\Album;

class MediaController extends Controller
{
    public function publicMedia(){
        $photos = Resource::where('type_id', 1)
                            ->where('format', 'image')
                            ->inRandomOrder()
                            ->limit(10)
                            ->get();
        $movies = Resource::where('type_id', 1)
                            ->where('format', 'video')
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
        $album_resources = AlbumResource::where('album_id', $id)->get();
        $resources = [];
        foreach($album_resources as $resource){
            $resources[] = $resource->resource_id;
        }
        $media = Resource::whereIn('id', $resources)->get();
        return view('media', compact('media'));
    }
}
