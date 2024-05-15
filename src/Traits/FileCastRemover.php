<?php

namespace Bl\LaravelUploadable\Traits;

use Bl\LaravelUploadable\Casts\FileCast;
use Bl\LaravelUploadable\FileCastHelper;

trait FileCastRemover
{
    protected static function bootFileCastRemover()
    {
        static::deleted(function($instance) {

            foreach($instance->casts as $attributeName => $parametersString) {

                if(\Str::startsWith($parametersString, FileCast::class)) {

                    list($directory, $disk, $driver) = FileCastHelper::getCastingParameters($parametersString);

                    // set the driver instance...
                    $driver = FileCastHelper::getDriverInstance($disk, $driver);

                    // set the file path...
                    $filePath = $instance->getRawOriginal($attributeName);

                    // deleting the file from it's path...
                    if($filePath) {
                        $driver->delete($filePath);
                    }

                }

            }

        });
    }
}
