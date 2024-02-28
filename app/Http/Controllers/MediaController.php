<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;

class MediaController extends Controller
{
    public function publicMedia(){
        $media = Resource::where('type_id', 1)->get();
        return view('media', compact('media'));
    }
}
