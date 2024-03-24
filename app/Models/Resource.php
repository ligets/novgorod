<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;
use App\Models\Album;
use App\Models\Type;
use App\Models\User;
use App\Models\AlbumResource;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'path',
        'format',
        'in_album',
        'type_id',
        'metadata_id'
    ];

    public function tags() {
        return $this->belongsToMany(Tag::class, 'resource_tags', 'resource_id', 'tag_id');
    }

    public function albums() {
        return $this->belongsToMany(Album::class, 'album_resources', 'resource_id', 'album_id');
    }

    public function album() {
        return $this->belongsTo(AlbumResource::class);
    }

    public function type() {
        return $this->belongsTo(Type::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function metadata(){
        return $this->belongsTo(Metadata::class);
    }
}
