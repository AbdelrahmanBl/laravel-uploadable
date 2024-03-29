<?php

namespace Bl\LaravelUploadable\Services;

use Bl\LaravelUploadable\Interfaces\UploadFileInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DriverService implements UploadFileInterface
{
    protected $disk;

    public function __construct(string $disk = '')
    {
        $this->disk = $disk;
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
     * @param  string|null $path
     * @return string
     */
    public function get(string|null $path): mixed
    {
        return Storage::disk($this->disk)->url($path);
    }

    /**
     * handle deleting a file.
     *
     * @param  string|null $path
     * @return void
     */
    public function delete(string|null $path): void
    {
        $path
        ? Storage::disk($this->disk)->delete($path)
        : NULL;
    }
}
