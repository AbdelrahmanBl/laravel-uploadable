<?php

namespace Bl\LaravelUploadable\Interfaces;

use Illuminate\Http\UploadedFile;

interface EventUploadInterface
{
    public function before(UploadedFile $file): UploadedFile;

    public function after(UploadedFile $file): void;
}
