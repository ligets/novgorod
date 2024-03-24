<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;

class SearchControllers extends Controller
{
    public function searchByTag(Request $request)
    {
        $tag = $request->input('tags');
        

        // Найти ресурсы, связанные с данным тегом
        $resources = Resource::where('type_id', '1')->whereHas('tags', function ($query) use ($tag) {
            $query->where('name', $tag);
        })->get()->groupBy('format');
        if(empty($tag)){
            $resources = Resource::where('type_id', '1')->get()->groupBy('format');
        }
        $images = $resources->get('image', collect()); // Получение массива ресурсов изображений
        $videos = $resources->get('video', collect()); // Получение массива ресурсов видео

        // Вывести найденные ресурсы
        return view('search_results', compact('images', 'videos'));
    }
}
