<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $req) {
        $req->validate([
            'login' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt($req->only('login', 'password'))){
            return redirect(route('profile'));
        }
        else{
            return redirect(route('login'))->with('error', 'Неверный логин или пароль');
        }
    }
}
