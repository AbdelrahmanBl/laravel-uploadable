<?php

namespace Bl\LaravelUploadable\Casts;

use Bl\LaravelUploadable\Traits\CanUploadFile;
use Exception;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Http\UploadedFile;

class FileCast implements CastsAttributes
{
    use CanUploadFile;

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
        return $this->__getFileAttribute($key, $value, $attributes, $model->uploadable);
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
        if(! $value instanceof UploadedFile && $value !== 'NULL') {

            throw new Exception("The {$key} attribute value must be instance of " . UploadedFile::class . ' or NULL as a string');

        }

        return $this->__setFileAttribute($key, $value, $attributes, $model->uploadable);
    }
}
