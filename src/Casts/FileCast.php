<?php

namespace Bl\LaravelUploadable\Casts;

use Bl\LaravelUploadable\Interfaces\UploadFileInterface;
use Bl\LaravelUploadable\UploadFile;
use Bl\LaravelUploadable\Services\DriverService;

class FileCast extends UploadFile
{
    protected $directory;

    protected $driver;

    public function __construct($directory = 'default', $disk = 'default', string $driver = 'default')
    {
        $this->directory = $directory;

        // overwrite disk with empty string to use default disk from filesystems config...
        if($disk === 'default') {
            $disk = '';
        }

        // overwrite driver if it exists...
        if($driver === 'default') {
            $this->driver = new DriverService($disk);
        }
        else {
            $this->driver = (
                class_exists($driver) &&
                new $driver($disk) instanceof UploadFileInterface
            )
            ? new $driver($disk)
            : new DriverService($disk);
        }
    }
}
