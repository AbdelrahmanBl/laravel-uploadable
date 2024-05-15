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

        $parametersArray = explode(',', $parametersString);

        // overwrite the first element in the parameters array with directory value...
        $parametersArray[0] = explode(':', $parametersArray[0])[1] ?? $directory->getValue();

        // parsing parameters...
        switch (count($parametersArray)) {
            case 1:
                $directory->setValue($parametersArray[0]);
                break;
            case 2:
                $directory->setValue($parametersArray[0]);
                $disk->setValue($parametersArray[1]);

                break;
            case 3:
                $directory->setValue($parametersArray[0]);
                $disk->setValue($parametersArray[1]);
                $driver->setValue($parametersArray[2]);

                break;
        }

        return [
            $directory,
            $disk,
            $driver,
        ];
    }
}
