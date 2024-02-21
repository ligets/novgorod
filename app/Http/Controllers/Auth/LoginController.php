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
        $data = $req->validate([
            'login' => 'required',
            'password' => 'required'
        ]);

        if(!Auth::attempt($data, $req->boolean('remember'))){
            throw ValidationException::withMessages([
                'email' => 'Неверный логин или пароль.'
            ]);
        }
        return redirect()->intended('/');        
    }
}
