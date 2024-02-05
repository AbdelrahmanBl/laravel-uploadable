<?php

namespace Bl\LaravelUploadable\Casts;

use Bl\LaravelUploadable\FileCastHelper;
use Bl\LaravelUploadable\Interfaces\UploadFileInterface;
use Illuminate\Http\UploadedFile;

class UploadFile
{
    protected $directory;

    protected $driver;

    protected $default;

    public function __construct(UploadFileInterface $driver)
    {
        $this->driver = $driver;
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

        // getting the default path when nullable...
        return match(true) {
            $this->default === 'default' => asset(config('filesystems.default_url', 'uploadable.jpg')),
            in_array($this->default, ['null', 'nullable']) => null,
            default => asset($this->default),
        };
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

            // set default directory if not overwritten...
            $directory = FileCastHelper::getDirectoryPath($this->directory, $model, $key);

            // handle delete old file if exists...
            if(array_key_exists($key, $attributes) && ! empty($attributes[$key])) {
                $this->driver->delete($attributes[$key]);
            }

            // storing the file in the directory...
            return $this->driver->store($value, $directory);

        }

        // return old value or null to skip the field update...
        return $attributes[$key] ?? NULL;

    }
}
