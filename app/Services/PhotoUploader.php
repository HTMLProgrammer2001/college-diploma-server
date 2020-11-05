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
        //save
        $path = $file->store($this->dirs['avatars']);

        //return url
        if(env('APP_ENV') == 'production')
            return Storage::disk('s3')->url($path);
        else
            return env('APP_URL') . '/storage/' . mb_substr($path, 6);
    }
}
