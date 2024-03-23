<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use App\Models\Album;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    public function get() {
        // $resources = Resource::where('user_id', Auth::user()->id)
        //                         ->where('type_id', 3);
        $user_id = Auth::user()->id;
        $resources = Resource::where('user_id', $user_id)
                                ->where('type_id', 3)
                                ->where('in_album', false)
                                ->get()
                                ->groupBy('format');
        
        $images = $resources->get('image', collect());
        $videos = $resources->get('video', collect());
        $albums = Auth::user()->albums;
        return view('gallery', compact('images', 'videos', 'albums'));
    }
    public function public() {
        $resources = Resource::where('type_id', 1)
                                ->where('in_album', false)
                                ->get()
                                ->groupBy('format');

        $images = $resources->get('image', collect());
        $videos = $resources->get('video', collect());

        $albums = Album::where('type_id', 1)->get();

        return view('public', compact('images', 'videos', 'albums'));
    }
}
