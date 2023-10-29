<?php

namespace Bl\LaravelUploadable\Casts;

use Bl\LaravelUploadable\Interfaces\UploadFileInterface;
use Bl\LaravelUploadable\Services\DriverService;
use Exception;

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

        // setting the default driver...
        if($driver === 'default') {
            $this->driver = new DriverService($disk);
        }
        else {
            // overwrite the driver...
            $this->driver = new $driver($disk);

            // checking the driver...
            if(! ($this->driver instanceof UploadFileInterface)) {
                throw new Exception($driver . ' must be an instance of ' . UploadFileInterface::class);
            }
        }


    }
}
