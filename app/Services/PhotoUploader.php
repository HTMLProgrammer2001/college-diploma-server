<?php


namespace App\Services;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PhotoUploader
{
    private $dirs = [
        'avatars' => 'public/avatars'
    ];

    public function uploadAvatar(UploadedFile $file): string {
        $name = Str::random(32) . '.' . $file->extension();
        Storage::putFileAs($this->dirs['avatars'], $file, $name);

        return $name;
    }
}
