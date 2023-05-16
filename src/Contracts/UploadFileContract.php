<?php

namespace Bl\LaravelUploadable\Contracts;

interface UploadFileContract
{
    public function getAttributeFile($key, $value, $attributes, $uploadable): mixed;

    public function setAttributeFile($key, $value, $attributes, $uploadable): mixed;
}
