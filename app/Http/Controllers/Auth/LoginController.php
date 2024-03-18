<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $req) {
        // Валидация приходящих данных
        $data = $req->validate([
            'login' => 'required',
            'password' => 'required'
        ], [ // Сообщения ошибки валидации
            'login.required' => 'Поле логина обязательно для заполнения.',
            'password.required' => 'Поле пароля обязательно для заполнения.'
        ]);
        // Если пользователя не удалось авторизовать, то выкидывает с контроллера с ошибкой
        if(!Auth::attempt($data, $req->boolean('remember'))){
            throw ValidationException::withMessages([
                'email' => 'Неверный логин или пароль.'
            ]);
        }
        // Регенерация сессии
        $req->session()->regenerate();

        /* Перенапровление на страницу куда пытался войти пользователь 
           или на главную страница*/
        return redirect()->intended('/');        
    }

    public function logout(Request $req){
        // Разлогиниваем пользователя
        Auth::logout();

        // Инвалидация сессии(удаление всех данных из сессии)
        $req->session()->invalidate();
        // Создание нового csrf токена
        $req->session()->regenerateToken();

        // Перенапровление на главную страницу
        return redirect('/');
    }
}
