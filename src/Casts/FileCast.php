<?php

namespace Bl\LaravelUploadable\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Bl\LaravelUploadable\Classes\PublicUploadFileAttribute;

class FileCast extends PublicUploadFileAttribute implements CastsAttributes
{
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
        return $this->getAttributeFile($key, $value, $attributes, $model->uploadable);
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
        return $this->setAttributeFile($key, $value, $attributes, $model->uploadable);
    }
}
