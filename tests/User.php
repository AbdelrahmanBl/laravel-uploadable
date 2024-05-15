<?php

namespace Bl\LaravelUploadable\Test;

use Illuminate\Database\Eloquent\Model;
use Bl\LaravelUploadable\Casts\FileCast;
use Bl\LaravelUploadable\Traits\FileCastRemover;

class User extends Model
{
    use FileCastRemover;

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
        'default_avatar' => FileCast::class,
        'custom_avatar_directory' => FileCast::class . ':CustomUser/avatars',
        'custom_avatar_disk' => FileCast::class . ':default,local',
        'custom_avatar_driver' => FileCast::class . ':default,default,' . CustomDriverService::class,
        'custom_avatar_default_path' => FileCast::class . ':default,default,default,custom_default_path.png',
        'custom_avatar_default_path_with_nullable' => FileCast::class . ':default,default,default,nullable',
    ];
}
