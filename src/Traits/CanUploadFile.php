<?php

namespace Bl\LaravelUploadable\Traits;

use Bl\LaravelUploadable\Services\UploadFileService;

trait CanUploadFile
{
    /**
     * when trying to get attribute from model.
     *
     * @param  mixed $key
     * @return mixed
     */
    public function getAttributeValue($key): mixed
    {
        if($this->isUploadableKey($key)) {

            return (new UploadFileService)->getFileUrl($this->attributes[$key]);

        }

        return parent::getAttributeValue($key);
    }

    /**
     * when trying to set attribute in model.
     *
     * @param  mixed $key
     * @param  mixed $value
     * @return mixed
     */
    public function setAttribute($key, $value): mixed
    {
        if($this->isUploadableKey($key)) {

            if(! empty($this->uploadable[$key])) {

                return $this->uploadFile($value, $key, $this->uploadable[$key]);

            }

        }

        return parent::setAttribute($key, $value);
    }

    /**
     * determine if the current field is uploadable key or not.
     *
     * @param  string $key
     * @return bool
     */
    protected function isUploadableKey(string $key): bool
    {
        return is_array($this->uploadable) && array_key_exists($key, $this->uploadable);
    }
}
