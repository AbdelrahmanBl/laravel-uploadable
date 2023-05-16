<?php

namespace Bl\LaravelUploadable\Classes;

use Exception;
use Illuminate\Http\UploadedFile;

class UploadFileAttribute
{
    /**
     * determine if the current field is uploadable key or not.
     *
     * @param  string   $key
     * @param  array    $uploadable
     * @return bool
     */
    protected function isUploadableKey($key, $uploadable): bool
    {
        return is_array($uploadable) && array_key_exists($key, $uploadable);
    }

    /**
     * determine that the uploaded file must be instance of \Illuminate\Http\UploadedFile
     *
     * @param  string $key
     * @param  mixed  $file
     * @return void
     */
    protected function checkUploadedFile($key, $file): void
    {
        if(! $file instanceof UploadedFile && $file !== 'NULL') {

            throw new Exception("The {$key} attribute value must be instance of " . UploadedFile::class . ' or NULL as a string');

        }
    }
}
