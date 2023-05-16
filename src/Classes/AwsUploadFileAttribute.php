<?php

namespace Bl\LaravelUploadable\Classes;

use Bl\LaravelUploadable\Contracts\UploadFileContract;

class AwsUploadFileAttribute extends UploadFileAttribute implements UploadFileContract
{
    public function getAttributeFile($key, $value, $attributes, $uploadable): mixed
    {
        // ...
    }

    public function setAttributeFile($key, $value, $attributes, $uploadable): mixed
    {
        // ...
    }
}
