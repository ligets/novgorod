<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\NewEmailNotification;
use Illuminate\Support\Facades\Auth;
use App\Models\EmailCode;
use Carbon\Carbon;

class EmailVerificateController extends Controller
{
    public function send(){
        $user = Auth::user();
        $code = $this->generateCode($user->email);
        $user->notify(new NewEmailNotification($code));
    }

    protected function generateCode($email){
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@!&?%#$';
        $code = substr(str_shuffle($permitted_chars), 0, 6);
        EmailCode::create([
            'email' => $email,
            'code' => $code,
            'lifespan' => Carbon::now()->timezone('Europe/Moscow')->addMinutes(10)->toDateTimeString()
        ]);
        return $code;
    }
}
