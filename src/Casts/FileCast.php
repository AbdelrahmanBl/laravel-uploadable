<?php

namespace Bl\LaravelUploadable\Casts;

use Illuminate\Http\UploadedFile;
use Bl\LaravelUploadable\FileCastHelper;
use Bl\LaravelUploadable\Classes\FileArgument;
use Bl\LaravelUploadable\Interfaces\UploadFileInterface;

class FileCast
{
    protected FileArgument $directory;

    protected UploadFileInterface $driver;

    protected FileArgument $default;

    /**
     * __construct
     *
     * @param  string $directory
     * @param  string $disk
     * @param  string $driver
     * @param  string $default
     * @return void
     */
    public function __construct($directory = 'default', $disk = 'default', $driver = 'default', $default = 'default')
    {
        $this->directory = new FileArgument($directory);

        // setting the default driver...
        $this->driver = FileCastHelper::getDriverInstance(new FileArgument($disk), new FileArgument($driver));

        // the default value to return when nullable...
        $this->default = new FileArgument($default);
    }

    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string   $key
     * @param  string   $value
     * @param  array    $attributes
     * @return array
     */
    public function get($model, $key, $value, $attributes)
    {
        if($value) {
            return $this->driver->get($value);
        }

        // getting the default path when empty...
        if($this->default->isDefault()) {
            return asset(config('filesystems.default_url', 'uploadable.jpg'));
        }

        // getting null value when empty...
        if($this->default->isNullable()) {
            return null;
        }

        // getting customized path when empty...
        return asset($this->default->getValue());
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string   $key
     * @param  \Illuminate\Http\UploadedFile        $value
     * @param  array    $attributes
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {
        if($value instanceof UploadedFile) {

            // handle delete old file if exists...
            if(array_key_exists($key, $attributes) && ! empty($attributes[$key])) {
                $this->driver->delete($attributes[$key]);
            }

            // storing the file in the directory...
            return $this->driver->store(
                $value,
                FileCastHelper::getDirectoryPath($this->directory, $model, $key)
            );

        }

        // return old value or null to skip the field update...
        return $attributes[$key] ?? NULL;

    }
}
