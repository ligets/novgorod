<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;
use App\Models\Album;
use App\Models\Type;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'path',
        'format',
        'in_album',
        'type_id'
    ];

    public function tags() {
        return $this->belongsToMany(Tag::class, 'resource_tags', 'resource_id', 'tag_id');
    }

    public function albums() {
        return $this->belongsToMany(Album::class, 'album_resources', 'resource_id', 'album_id');
    }

    public function type() {
        return $this->belongsTo(Type::class);
    }
}
