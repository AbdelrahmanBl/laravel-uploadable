<?php

namespace Bl\LaravelUploadable\Casts;

use Bl\LaravelUploadable\UploadFile;
use Bl\LaravelUploadable\Services\PublicDriverService;

class FileCast extends UploadFile
{
    protected $driver;

    protected $directory;

    public function __construct($directory = NULL)
    {
        $this->directory = $directory;

        $this->driver = new PublicDriverService;
    }
}
