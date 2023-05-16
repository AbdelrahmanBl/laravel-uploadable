<?php

namespace Bl\LaravelUploadable\Casts;

use Bl\LaravelUploadable\Classes\AwsUploadFileAttribute;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class AwsFileCast extends AwsUploadFileAttribute implements CastsAttributes
{
    /**
     * TODO: Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string   $key
     * @param  string   $value
     * @param  array    $attributes
     * @return array
     */
    public function get($model, $key, $value, $attributes)
    {
        // ...
    }

    /**
     * TODO: Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string   $key
     * @param  \Illuminate\Http\UploadedFile        $value
     * @param  array    $attributes
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {
        // ...
    }
}
