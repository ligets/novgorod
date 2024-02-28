<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageOrVideo implements Rule
{
    public function passes($attribute, $value)
    {
        $mime = File::mimeType($value->path());
        return Str::startsWith($mime, 'image/') || Str::startsWith($mime, 'video/');
    }

    public function message()
    {
        return 'Файл должен быть изоброжением или видеом.';
    }
}
