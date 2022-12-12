<?php

namespace Bl\LaravelUploadable\Traits;

use Bl\LaravelUploadable\Services\UploadFileService;
use Illuminate\Http\UploadedFile;

trait HasMoveable
{
    /**
     * Upload file to specific directory and store the path in the table field.
     *
     * @param  UploadedFile|null $file
     * @param  string        $field
     * @param  string        $dir
     * @return string|null
     */
    public function uploadFile(UploadedFile|null $file, string $field, string $dir): ?string
    {
        if($file instanceof UploadedFile) {

            (new UploadFileService)->deleteFile($field, $this->attributes);

            //
        }

        return null;
    }
}
