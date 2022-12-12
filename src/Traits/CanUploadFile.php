<?php

namespace Bl\LaravelUploadable\Traits;

use Bl\LaravelUploadable\Actions\GetFileUrl;

trait CanUploadFile
{
    use HasUploadable;

    /**
     * when trying to get attribute from model.
     *
     * @param  string   $key
     * @param  mixed    $value
     * @param  array    $attributes
     * @param  array    $uploadable
     * @return mixed
     */
    public function __getFileAttribute($key, $value, $attributes, $uploadable): mixed
    {
        if($this->isUploadableKey($key, $uploadable)) {

            return (new GetFileUrl)->handle($value);

        }

        return $value;
    }

    /**
     * when trying to set attribute in model.
     *
     * @param  string   $key
     * @param  mixed    $value
     * @param  array    $attributes
     * @param  array    $uploadable
     * @return mixed
     */
    public function __setFileAttribute($key, $value, $attributes, $uploadable): mixed
    {
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
}
