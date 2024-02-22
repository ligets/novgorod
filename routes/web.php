<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
})->name('home');

/* Создание группы маршрутов авторизации/регистрации/выхода,
   с проверкой от кого идет запрос(если от гостя то запрос отправляется)
   с Префиксом auth/...
   Перенапровление идёт на соответствующие контроллеры */
Route::middleware('guest')->prefix('auth')->group(function () {
    Route::post('/login', 'App\\Http\\Controllers\\Auth\\LoginController@login')->name('login');
    Route::post('/registration', 'App\\Http\\Controllers\\Auth\\RegistrController@registr')->name('registration');
    Route::post('/logout', 'App\\Http\\Controllers\\Auth\\LoginController@logout')->name('logout');
});

/* Создание группы маршрутов
   которые доступны только авторизованному пользователю */
Route::middleware(['auth'/*, 'verified'*/])->group(function () {
    Route::get('/profile', function() {
        return view('profile');
    })->name('profile');

    //Сделать динамические ссылки альбома && редактора фото

});
