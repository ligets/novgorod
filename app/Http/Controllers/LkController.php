<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LkController extends Controller
{
    public function get(){
        $user = Auth::user();
        return view('lk', compact('user'));
    }
}
