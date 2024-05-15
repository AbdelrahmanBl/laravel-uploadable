<?php

namespace Bl\LaravelUploadable\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Bl\LaravelUploadable\Interfaces\UploadFileInterface;

class DriverService implements UploadFileInterface
{
    protected $disk;

    /**
     * __construct
     *
     * @param  \Bl\LaravelUploadable\Classes\FileArgument $disk
     * @return void
     */
    public function __construct($disk)
    {
        $this->disk = $disk->isDefault() ? '' : $disk->getValue();
    }

    /**
     * handle store proccess of the file.
     *
     * @param  UploadedFile $file
     * @param  string $directory
     * @return mixed
     */
    public function store(UploadedFile $file, string $directory): mixed
    {
        return $file->store($directory, $this->disk);
    }

    /**
     * handle getting the file full url path.
     *
     * @param  string $path
     * @return string
     */
    public function get(string $path): mixed
    {
        return Storage::disk($this->disk)->url($path);
    }

    /**
     * handle deleting a file.
     *
     * @param  string $path
     * @return void
     */
    public function delete(string $path): void
    {
        Storage::disk($this->disk)->delete($path);
    }
}
