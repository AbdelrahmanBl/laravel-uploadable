<?php

namespace Bl\LaravelUploadable\Actions;

use Illuminate\Support\Facades\Storage;

class DeleteFileAction
{
    /**
     * handle deleting a file.
     *
     * @param  string $key
     * @param  array  $attributes
     * @return void
     */
    public function handle(string $key, array $attributes)
    {
        if(array_key_exists($key, $attributes) && !empty($attributes[$key])) {

            Storage::delete($attributes[$key]);

        }
    }
}
