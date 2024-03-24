<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;
use App\Jobs\ObjectDetection;

class PyController extends Controller
{
    public static function objectDetection($resource_id){
        ObjectDetection::dispatch($resource_id);
    }  
}
