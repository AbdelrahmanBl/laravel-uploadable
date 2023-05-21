<?php

namespace Bl\LaravelUploadable\Casts;

use Bl\LaravelUploadable\Services\S3DriverService;
use Bl\LaravelUploadable\UploadFile;

class S3FileCast extends UploadFile
{
    protected $driver;

    public function __construct()
    {
        $this->driver = new S3DriverService;
    }


}
