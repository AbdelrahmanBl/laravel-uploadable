<?php

namespace Bl\LaravelUploadable\Test\Models;

use Illuminate\Database\Eloquent\Model;
use Bl\LaravelUploadable\Casts\FileCast;
use Bl\LaravelUploadable\Test\Services\CustomUploadService;

class CustomEventModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'default_avatar' => FileCast::class . ':default,default,default,default,' . CustomUploadService::class,
    ];
}
