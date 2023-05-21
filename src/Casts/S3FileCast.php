<?php

namespace Bl\LaravelUploadable\Casts;

use Bl\LaravelUploadable\Services\S3DriverService;
use Bl\LaravelUploadable\UploadFile;

class S3FileCast extends UploadFile
{
    protected $driver;

    protected $directory;

    public function __construct($directory)
    {
        $this->directory = $directory;

        $this->driver = new S3DriverService;
    }


}
