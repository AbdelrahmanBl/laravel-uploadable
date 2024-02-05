<?php

namespace Bl\LaravelUploadable\Casts;

use Bl\LaravelUploadable\FileCastHelper;

class FileCast extends UploadFile
{
    protected $directory;

    protected $driver;

    protected $default;

    public function __construct($directory = 'default', $disk = 'default', string $driver = 'default', string $default = 'default')
    {
        $this->directory = $directory;

        // setting the default driver...
        $this->driver = FileCastHelper::getDriverInstance($disk, $driver);

        // the default value to return when nullable...
        $this->default = $default;
    }
}
