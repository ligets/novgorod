<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegistrController extends Controller {
    public function registr(Request $req){
        $req->validate([
            'login' => 'required|unique:user|string|min:5|max:255',
            'email' => 'required|unique:user|email|max:255',
            'password' => 'required|confirmed|min:8|max:255'
        ]);
        $user = User::create([
            'login' => $req->login,
            'email' => $req->email,
            'password' => Hash::make($req->password)
        ]);
        Auth::login($user);
        return redirect(route('profile'));
    }
}
