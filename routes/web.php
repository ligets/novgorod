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

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('time', function () {
    $password = 'legen2a777';
    echo Hash::make($password);
});

Route::get('media', 'App\\Http\\Controllers\\MediaController@publicMedia');


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

/* Создание группы маршрутов
   которые доступны только авторизованному пользователю */
Route::middleware(['auth'/*, 'verified'*/])->group(function () {
    Route::get('/profile', function() {
        return view('profile');
    })->name('profile');

    Route::post('resources/upload', 'App\\Http\\Controllers\\ResourcesController@store')->name('upload.store');
    
    Route::get('albums/{id}', 'App\\Http\\Controllers\\AlbumsController@get');
    Route::get('albums/{id}/edit', 'App\\Http\\Controllers\\AlbumsController@edit_authors');
});
