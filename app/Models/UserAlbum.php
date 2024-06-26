<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAlbum extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 
        'album_id', 
        'role'
    ];
}
