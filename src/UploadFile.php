<?php

namespace Bl\LaravelUploadable;

use Bl\LaravelUploadable\Interfaces\UploadFileInterface;
use Exception;
use Illuminate\Http\UploadedFile;

class UploadFile
{
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
        if($this->isUploadableKey($key, $model->uploadable)) {

            return $this->driver->get($value) ?? asset(config('filesystems.uploadable', 'uploadable.jpg'));

        }

        return $value;
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
        $uploadable = $model->uploadable;

        $this->checkUploadedFile($key, $value);

        if($this->isUploadableKey($key, $uploadable)) {

            if(! empty($uploadable[$key])) {

                return $this->uploadFile($key, $value, $uploadable[$key], $attributes);

            }

            return $attributes[$key];

        }

        return $value;
    }

    /**
     * determine if the current field is uploadable key or not.
     *
     * @param  string   $key
     * @param  array    $uploadable
     * @return bool
     */
    protected function isUploadableKey($key, $uploadable): bool
    {
        return is_array($uploadable) && array_key_exists($key, $uploadable);
    }

    /**
     * determine that the uploaded file must be instance of \Illuminate\Http\UploadedFile
     *
     * @param  string $key
     * @param  mixed  $file
     * @return void
     */
    protected function checkUploadedFile($key, $file): void
    {
        if(! $file instanceof UploadedFile && $file !== 'NULL') {

            throw new Exception("The {$key} attribute value must be instance of " . UploadedFile::class . ' or NULL as a string');

        }
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

            $this->driver->delete($key, $attributes);

            return $this->driver->store($file, $dir);

        }

        return $attributes[$key] ?? null;
    }
}
