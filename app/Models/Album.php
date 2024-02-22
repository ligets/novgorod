<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Album extends Model
{
    use HasFactory;

    public function authors() {
        return $this->belongsToMany(User::class, 'user_albums', 'album_id', 'user_id');
    }
}
