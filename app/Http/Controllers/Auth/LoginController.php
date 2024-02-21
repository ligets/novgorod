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

        $user = User::where('login', $req->login);
        if($user){
            if (Hash::check($req->password, $user->password)) {
                Auth::login($user);
                return redirect(route('profile'));
            }
            else {
                return redirect(route('login'))->with('error', 'Неверный логин или пароль');
            }
        }
        else{
            return redirect(route('login'))->with('error', 'Неверный логин или пароль');
        }
    }
}
