<?php

namespace Bl\LaravelUploadable\Actions;

use Illuminate\Support\Facades\Storage;

class GetFileUrl
{
    /**
     * handle getting the file full url path.
     *
     * @param  string|null $path
     * @return string
     */
    public function handle(?string $path): string
    {
        return $path ? Storage::url($path) : asset('uploadable.jpg');
    }
}
