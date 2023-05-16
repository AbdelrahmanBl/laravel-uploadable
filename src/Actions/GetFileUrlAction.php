<?php

namespace Bl\LaravelUploadable\Actions;

use Illuminate\Support\Facades\Storage;

class GetFileUrlAction
{
    /**
     * handle getting the file full url path.
     *
     * @param  string|null $path
     * @return string
     */
    public function handle(string|null $path)
    {
        return $path ? Storage::url($path) : asset('uploadable.jpg');
    }
}
