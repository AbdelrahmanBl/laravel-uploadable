<?php

namespace Bl\LaravelUploadable\Actions;

use Illuminate\Http\UploadedFile;

class UploadFileAction
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
    public function handle(string $key, mixed $file, string $dir, array $attributes)
    {
        if($file instanceof UploadedFile) {

            (new DeleteFileAction)->handle($key, $attributes);

            return $file->store($dir);

        }

        return $attributes[$key] ?? null;
    }
}
