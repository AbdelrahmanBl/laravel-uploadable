<?php

namespace Bl\LaravelUploadable\Casts;

use Bl\LaravelUploadable\Interfaces\UploadFileInterface;
use Illuminate\Http\UploadedFile;

class UploadFile
{
    protected $directory;

    protected $driver;

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
        return $value
        ? $this->driver->get($value)
        : asset(config('filesystems.default_url', 'uploadable.jpg'));
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

            $file = $value;

            // set default directory if not overwritten...
            $directory = $this->directory === 'default'
                        ? class_basename($model) . '/' . $key
                        : $this->directory;

            // handle delete old file if exists...
            if(array_key_exists($key, $attributes) && ! empty($attributes[$key])) {
                $this->driver->delete($attributes[$key]);
            }

            // storing the file in the directory...
            return $this->driver->store($file, $directory);

        }

        // return old value or null to skip the field update...
        return $attributes[$key] ?? NULL;

    }
}
