<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use App\Models\AlbumResource;

class MediaController extends Controller
{
    public function publicMedia(){
        $media = Resource::where('type_id', 1)->get();
        return view('media', compact('media'));
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
