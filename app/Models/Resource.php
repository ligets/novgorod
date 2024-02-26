<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;
use App\Models\Album;

class Resource extends Model
{
    use HasFactory;

    public function tags() {
        return $this->belongsToMany(Tag::class, 'resource_tags', 'resource_id', 'tag_id');
    }

    public function albums() {
        return $this->belongsToMany(Album::class, 'album_resources', 'resource_id', 'album_id');
    }
}
