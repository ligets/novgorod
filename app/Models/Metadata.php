<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metadata extends Model
{
    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }
}
