<?php

namespace Bl\LaravelUploadable;

use Bl\LaravelUploadable\Interfaces\UploadFileInterface;
use Bl\LaravelUploadable\Services\DriverService;
use Exception;

class FileCastHelper
{
    /**
     * overwrite disk with empty string to use default disk from filesystems config...
     *
     * @param  string $disk
     * @return string
     */
    public static function getDiskName($disk)
    {
        if($disk === 'default') {
            $disk = '';
        }

        return $disk;
    }

    /**
     * get default driver instance or overwrite it...
     *
     * @param  string $disk
     * @param  string $driver
     * @return object
     */
    public static function getDriverInstance($disk, $driver)
    {
        $disk = static::getDiskName($disk);

        // setting the default driver...
        if($driver === 'default') {
            $driver = new DriverService($disk);
        }
        else {
            // overwrite the driver...
            $driver = new $driver($disk);

            // checking the driver...
            if(! ($driver instanceof UploadFileInterface)) {
                throw new Exception($driver . ' must be an instance of ' . UploadFileInterface::class);
            }
        }

        return $driver;
    }

    /**
     * get default directory path or customize it...
     *
     * @param  string $directory
     * @param  object $model
     * @param  string $key
     * @return string
     */
    public static function getDirectoryPath($directory, $model, $key)
    {
        // set the default directory...
        if($directory === 'default') {
            $directory = class_basename($model);
        }

        return $directory  . DIRECTORY_SEPARATOR . $key;
    }

    /**
     * get file cast parameters as an array...
     *
     * @param  mixed $parametersString
     * @return void
     */
    public static function getCastingParameters($parametersString)
    {
        $directory = 'default';
        $disk = 'default';
        $driver = 'default';

        $parametersArray = explode(',', $parametersString);
        $parametersArrayCount = count($parametersArray);

        // setting the directory...
        $parametersArray[0] = explode(':', $parametersArray[0])[1] ?? $directory;

        // parsing parameters...
        switch ($parametersArrayCount) {
            case 1:
                list($directory) = $parametersArray;
                break;
            case 2:
                list($directory, $disk) = $parametersArray;
                break;
            case 3:
                list($directory, $disk, $driver) = $parametersArray;
                break;
        }

        return [
            $directory,
            $disk,
            $driver,
        ];
    }
}
