<?php

namespace Bl\LaravelUploadable\Traits;

use Bl\LaravelUploadable\Actions\DeleteFile;
use Illuminate\Http\UploadedFile;

trait HasUploadable
{
    /**
     * Upload file to specific directory and store the path in the table field.
     *
     * @param  UploadedFile  $file
     * @param  string        $key
     * @param  string        $dir
     * @param  array         $attributes
     * @return string|null
     */
    public function uploadFile(string $key, mixed $file, string $dir, array $attributes): ?string
    {
        if($file instanceof UploadedFile) {

            (new DeleteFile)->handle($key, $attributes);

            return $file->store($dir);

        }

        return $attributes[$key];
    }
}
