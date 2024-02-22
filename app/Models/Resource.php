<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    public function tags() {
        return $this->belongsToMany(Tag::class, 'resource_tags', 'resource_id', 'tag_id');
    }
}
