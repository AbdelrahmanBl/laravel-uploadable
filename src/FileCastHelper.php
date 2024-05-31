<?php

namespace Bl\LaravelUploadable;

use Bl\LaravelUploadable\Classes\FileArgument;
use Bl\LaravelUploadable\Services\DriverService;

class FileCastHelper
{
    /**
     * get default driver instance or overwrite it...
     *
     * @param  \Bl\LaravelUploadable\Classes\FileArgument $disk
     * @param  \Bl\LaravelUploadable\Classes\FileArgument $driver
     * @return \Bl\LaravelUploadable\Interfaces\UploadFileInterface
     */
    public static function getDriverInstance($disk, $driver)
    {
        return $driver->isDefault()
        ? new DriverService($disk)
        : new ($driver->getValue())($disk);
    }

    /**
     * get default directory path or customize it...
     *
     * @param  \Bl\LaravelUploadable\Classes\FileArgument $directory
     * @param  object $model
     * @param  string $key
     * @return string
     */
    public static function getDirectoryPath($directory, $model, $key)
    {
        // set the default directory...
        if($directory->isDefault()) {
            $directory->setValue(class_basename($model) . DIRECTORY_SEPARATOR . $key);
        }

        return $directory->getValue();
    }

    /**
     * get file cast parameters as an array...
     *
     * @param  string $parametersString
     * @return array<\Bl\LaravelUploadable\Classes\FileArgument>
     */
    public static function getCastingParameters($parametersString)
    {
        $disk = new FileArgument();
        $driver = new FileArgument();
        $directory = new FileArgument();

        // unpacking parameters...
        $parametersArray = explode(',', $parametersString);

        // reset first element with custom directory value or null when default...
        $parametersArray[0] = explode(':', $parametersArray[0])[1] ?? null;

        // set custom directory...
        if(! empty($parametersArray[0])) {
            $directory->setValue($parametersArray[0]);
        }

        // set custom disk...
        if(! empty($parametersArray[1])) {
            $disk->setValue($parametersArray[1]);
        }

        // set custom driver...
        if(! empty($parametersArray[2])) {
            $driver->setValue($parametersArray[2]);
        }

        return [
            $directory,
            $disk,
            $driver,
        ];
    }
}
