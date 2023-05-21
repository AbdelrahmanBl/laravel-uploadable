<?php

namespace Bl\LaravelUploadable\Casts;

use Bl\LaravelUploadable\UploadFile;
use Bl\LaravelUploadable\Services\PublicDriverService;

class FileCast extends UploadFile
{
    protected $driver;

    public function __construct()
    {
        $this->driver = new PublicDriverService;
    }
}
