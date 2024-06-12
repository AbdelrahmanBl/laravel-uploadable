<?php

namespace Bl\LaravelUploadable\Test\Models;

use Bl\LaravelUploadable\Casts\FileCast;
use Bl\LaravelUploadable\Test\Services\CustomUploadService;

class OverwriteEventModel extends GlobalEventModel
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'default_avatar' => FileCast::class . ':default,default,default,default,' . CustomUploadService::class,
    ];
}
