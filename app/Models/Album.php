<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Type;

class Album extends Model
{
    use HasFactory;


    public function type() {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function authors() {
        return $this->belongsToMany(User::class, 'user_albums', 'album_id', 'user_id');
    }
}
