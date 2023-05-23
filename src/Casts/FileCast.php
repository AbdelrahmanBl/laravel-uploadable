<?php

namespace Bl\LaravelUploadable\Casts;

use Bl\LaravelUploadable\UploadFile;
use Bl\LaravelUploadable\Services\DriverService;

class FileCast extends UploadFile
{
    protected $driver;

    protected $directory;

    public function __construct($directory = NULL, $disk = NULL)
    {
        $this->directory = $directory;

        $this->driver = new DriverService($disk);
    }
}
