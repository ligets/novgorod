<?php

use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use App\Models\Album;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/py', 'App\\Http\\Controllers\\PyController@handle');
// Route::get('/', function () {
//     return view('home');
//     //C:\Users\Danil\Desktop\novgorod\storage\app\py_scripts\SSD_OD\main.py
//     //echo 'C:\Users\Danil\Desktop\novgorod\storage\app\py_scripts\SSD_OD\main.py';
//     // return base_path('\storage\app\py_scripts\SSD_OD\main.py');
//     // $script_path = str_replace('\\', '/', base_path('\storage\app\py_scripts\SSD_OD\main.py'));
    
//     // $image_path = base_path('storage\\app\\public\\' . 'upload/image-jpeg/2024-02-09/78067c142e4ded9d00e046771269aade.jpg');
    
//     // $indexes = shell_exec("python {$script_path} {$image_path}");
//     // return $indexes;
//     // preg_match_all('/\d+/', $indexes, $matches);

//     // // Получаем массив чисел из строки      
//     // $numbers = $matches[0];

//     // // Преобразуем числа из строки в числа
//     // $indexes = array_map('intval', $numbers);
//     // return $indexes;
//     // // Проходим по каждому индексу из $indexes и добавляем соответствующее слово в массив $words
//     // foreach ($indexes as $index) {
//     //     // Если индекс есть в словаре, добавляем соответствующее слово в массив $words
//     //     if (isset($this->coco_names[$index])) {
//     //         $tag = Tag::firstOrCreate([
//     //             'name' => $this->coco_names[$index]
//     //         ]);
//     //         $this->resource->tags()->attach($tag->id, ['resource_id' => $resource->id]);
//     //     }
//     // }
// })->name('home');

Route::get('time', function () {
    $password = 'legen2a777';
    echo Hash::make($password);
});

Route::get('email', 'App\Http\Controllers\Auth\EmailVerificateController@send');

Route::get('/', 'App\\Http\\Controllers\\MediaController@publicMedia');

Route::get('/upload', function() {
    return view('upload');
});

/* Создание группы маршрутов авторизации/регистрации/выхода,
   с проверкой от кого идет запрос(если от гостя то запрос отправляется)
   с Префиксом auth/...
   Перенапровление идёт на соответствующие контроллеры */
Route::middleware('guest')->prefix('auth')->group(function () {
    Route::get('/login', function () {
        return view('login');
    })->name('get_login');


    Route::post('/login', 'App\\Http\\Controllers\\Auth\\LoginController@login')->name('post_login');
    Route::post('/registration', 'App\\Http\\Controllers\\Auth\\RegistrController@registr')->name('registration');
    Route::post('/logout', 'App\\Http\\Controllers\\Auth\\LoginController@logout')->name('logout');
});

Route::get('resources/download/{type}/{id}', 'App\\Http\\Controllers\\ResourcesController@download')->name('download.store');
Route::get('public', 'App\\Http\\Controllers\\GalleryController@public')->name('publuc');
Route::get('albums/{id}', 'App\\Http\\Controllers\\AlbumsController@get');

/* Создание группы маршрутов
   которые доступны только авторизованному пользователю */
Route::middleware(['auth'/*, 'verified'*/])->group(function () {
    Route::get('/profile', function() {
        return view('profile');
    })->name('profile');
    Route::get('/lk', 'App\\Http\\Controllers\\LkController@get')->name('lk');
    Route::get('gallery', 'App\\Http\\Controllers\\GalleryController@get')->name('gallary');
    Route::post('resources/upload', 'App\\Http\\Controllers\\ResourcesController@store')->name('upload.store');
    
    
    Route::get('albums/{id}/edit', 'App\\Http\\Controllers\\AlbumsController@edit_authors');
});
