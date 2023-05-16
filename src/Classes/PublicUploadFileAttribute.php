<?php

namespace Bl\LaravelUploadable\Classes;

use Bl\LaravelUploadable\Actions\GetFileUrlAction;
use Bl\LaravelUploadable\Actions\UploadFileAction;
use Bl\LaravelUploadable\Contracts\UploadFileContract;

class PublicUploadFileAttribute extends UploadFileAttribute implements UploadFileContract
{
    /**
     * when trying to get attribute from model.
     *
     * @param  string   $key
     * @param  mixed    $value
     * @param  array    $attributes
     * @param  array    $uploadable
     * @return mixed
     */
    public function getAttributeFile($key, $value, $attributes, $uploadable): mixed
    {
        if($this->isUploadableKey($key, $uploadable)) {

            return (new GetFileUrlAction)->handle($value);

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
    public function setAttributeFile($key, $value, $attributes, $uploadable): mixed
    {
        $this->checkUploadedFile($key, $value);

        if($this->isUploadableKey($key, $uploadable)) {

            if(! empty($uploadable[$key])) {

                return (new UploadFileAction)->handle($key, $value, $uploadable[$key], $attributes);

            }

            return $attributes[$key];

        }

        return $value;
    }
}
