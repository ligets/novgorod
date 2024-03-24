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

// Route::get('email', 'App\Http\Controllers\Auth\EmailVerificateController@send');

Route::get('/', 'App\\Http\\Controllers\\MediaController@publicMedia')->name('home');

/* Создание группы маршрутов авторизации/регистрации/выхода,
   с проверкой от кого идет запрос(если от гостя то запрос отправляется)
   с Префиксом auth/...
   Перенапровление идёт на соответствующие контроллеры */
Route::middleware('guest')->prefix('auth')->group(function () {
    Route::post('/login', 'App\\Http\\Controllers\\Auth\\LoginController@login')->name('post_login');
    Route::post('/registration', 'App\\Http\\Controllers\\Auth\\RegistrController@registr')->name('registration');
    
});

Route::get('resources/download/{type}/{id}', 'App\\Http\\Controllers\\ResourcesController@download')->name('download.store');
Route::get('public', 'App\\Http\\Controllers\\GalleryController@public')->name('public');
Route::get('albums/{id}', 'App\\Http\\Controllers\\AlbumsController@get');

/* Создание группы маршрутов
   которые доступны только авторизованному пользователю */
Route::middleware(['auth'/*, 'verified'*/])->group(function () {
    Route::get('/profile', function() {
        return view('profile');
    })->name('profile');
    Route::post('auth/logout', 'App\\Http\\Controllers\\Auth\\LoginController@logout')->name('logout');
    Route::get('/lk', 'App\\Http\\Controllers\\LkController@get')->name('lk');
    Route::get('gallery', 'App\\Http\\Controllers\\GalleryController@get')->name('gallary');
    Route::post('resources/upload', 'App\\Http\\Controllers\\ResourcesController@store')->name('upload.store');
    Route::post('edit-album', 'App\\Http\\Controllers\\AlbumsController@edit');
    Route::post('create-album', 'App\\Http\\Controllers\\AlbumsController@create');
    Route::post('/photo/delete', 'App\\Http\\Controllers\\MediaController@delete');
});

Route::post('/photo/map', 'App\\Http\\Controllers\\MediaController@getMap');
Route::get('/search', 'App\Http\Controllers\SearchControllers@searchByTag')->name('search');
