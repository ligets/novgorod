<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegistrController extends Controller {
    public function registr(Request $req) {
        // Валидация приходящих данных
        $req->validate([
            'login' => 'required|unique:users|string|min:5|max:255',
            'email' => 'required|unique:users|email|max:255',
            'password' => 'required|confirmed|min:8|max:255'
        ], [ // Сообщения ошибки валидации
            'login.required' => 'Поле логина обязательно для заполнения.',
            'login.unique' => 'Пользователь с таким логином уже существует.',
            'login.string' => 'Поле логина должно быть строкой.',
            'login.min' => 'Поле логина должно содержать минимум :min символов.',
            'login.max' => 'Поле логина не должно превышать :max символов.',
            
            'email.required' => 'Поле электронной почты обязательно для заполнения.',
            'email.unique' => 'Пользователь с такой электронной почтой уже существует.',
            'email.email' => 'Поле электронной почты должно быть действительным адресом электронной почты.',
            'email.max' => 'Поле электронной почты не должно превышать :max символов.',
            
            'password.required' => 'Поле пароля обязательно для заполнения.',
            'password.confirmed' => 'Пароль не совпадает с его подтверждением.',
            'password.min' => 'Поле пароля должно содержать минимум :min символов.',
            'password.max' => 'Поле пароля не должно превышать :max символов.'
        ]);

        // Создание нового пользователя в БД
        // return $req->login;
        $user = User::create([
            'login' => $req->login,
            'email' => $req->email,
            'password' => Hash::make($req->password), // Создание хэшированого пароля
            'role_id' => 2
        ]);

        // Авторизовывем пользователя
        Auth::login($user);

        //Перенапровление на страницу профиля
        return redirect(route('lk'));
    }
}
