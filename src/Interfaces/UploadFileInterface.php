<?php

namespace Bl\LaravelUploadable\Interfaces;

use Illuminate\Http\UploadedFile;

interface UploadFileInterface
{
    public function store(UploadedFile $file, string $directory): mixed;

    public function get(string|null $path): mixed;

    public function delete(string $key, array $attributes): void;
}
