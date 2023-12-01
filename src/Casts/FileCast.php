<?php

namespace Bl\LaravelUploadable\Casts;

use Bl\LaravelUploadable\FileCastHelper;

class FileCast extends UploadFile
{
    protected $directory;

    protected $driver;

    public function __construct($directory = 'default', $disk = 'default', string $driver = 'default')
    {
        $this->directory = $directory;

        // setting the default driver...
        $this->driver = FileCastHelper::getDriverInstance($disk, $driver);
    }
}
