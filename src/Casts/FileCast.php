<?php

namespace Bl\LaravelUploadable\Casts;

use Illuminate\Http\UploadedFile;
use Bl\LaravelUploadable\FileCastHelper;
use Bl\LaravelUploadable\Classes\FileArgument;
use Bl\LaravelUploadable\Interfaces\EventUploadInterface;
use Bl\LaravelUploadable\Interfaces\UploadFileInterface;

class FileCast
{
    protected FileArgument $directory;

    protected UploadFileInterface $driver;

    protected FileArgument $default;

    protected FileArgument $event;

    protected EventUploadInterface $customEventService;

    /**
     * __construct
     *
     * @param  string $directory
     * @param  string $disk
     * @param  string $driver
     * @param  string $default
     * @param  string $event
     * @return void
     */
    public function __construct($directory = 'default', $disk = 'default', $driver = 'default', $default = 'default', $event = 'default')
    {
        $this->directory = new FileArgument($directory);

        // setting the default driver...
        $this->driver = FileCastHelper::getDriverInstance(new FileArgument($disk), new FileArgument($driver));

        // the default value to return when nullable...
        $this->default = new FileArgument($default);

        $this->event = new FileArgument($event);
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
     * @param  string  $key
     * @param  \Illuminate\Http\UploadedFile  $value
     * @param  array  $attributes
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {
        if($value instanceof UploadedFile) {

            // handle delete old file if exists...
            if(array_key_exists($key, $attributes) && ! empty($attributes[$key])) {
                $this->driver->delete($attributes[$key]);
            }

            // set custom event service...
            if($this->event->isCustom()) {
                $this->customEventService = new ($this->event->getValue())();
            }

            // handle before file upload global event...
            // TODO apply test case & add to readMe
            $value = $this->handleBeforeUpload($value, $model);

            // storing the file in the directory...
            $storedPath = $this->driver->store(
                $value,
                FileCastHelper::getDirectoryPath($this->directory, $model, $key)
            );

            // handle after file upload global event...
            // TODO apply test case & add to readMe
            $this->handleAfterUpload($value, $model);

            // overwrite the model with the stored path...
            $model->{$key} = $storedPath;

            return $storedPath;

        }

        // return old value or null to skip the field update...
        return $attributes[$key] ?? NULL;

    }

    /**
     * handle before uploading the file.
     *
     * @param  \Illuminate\Http\UploadedFile $file
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Http\UploadedFile
     */
    public function handleBeforeUpload($file, $model)
    {
        // custom event service...
        if(isset($this->customEventService)) {
            return $this->customEventService->before($file);
        }

        // global event service...
        if(method_exists($model, 'beforeFileCastUpload')) {
            return $model->beforeFileCastUpload($file);
        }

        return $file;
    }

    public function handleAfterUpload($file, $model)
    {
        // custom event service...
        if(isset($this->customEventService)) {
            $this->customEventService->after($file);
        }

        // global event service...
        if(method_exists($model, 'afterFileCastUpload')) {
            return $model->afterFileCastUpload($file);
        }
    }
}
