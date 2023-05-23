<?php

namespace Bl\LaravelUploadable;

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
        return $value ? $this->driver->get($value) : asset(config('filesystems.uploadable', 'uploadable.jpg'));
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

            $directory = $this->directory ?? class_basename($model) . '/' . $key;

            return $this->uploadFile($key, $value, $directory, $attributes);

        }

        return $attributes[$key] ?? NULL;

    }

    /**
     * Upload file to specific directory and store the path in the table field.
     *
     * @param  UploadedFile  $file
     * @param  string        $key
     * @param  string        $dir
     * @param  array         $attributes
     * @return string|null
     */
    protected function uploadFile(string $key, mixed $file, string $dir, array $attributes): mixed
    {
        if($file instanceof UploadedFile) {

            if(array_key_exists($key, $attributes) && !empty($attributes[$key])) {

                $this->driver->delete($key, $attributes);

            }

            return $this->driver->store($file, $dir);

        }

        return $attributes[$key] ?? null;
    }
}
