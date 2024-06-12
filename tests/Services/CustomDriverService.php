<?php

namespace Bl\LaravelUploadable\Test\Services;

use Illuminate\Http\UploadedFile;
use Bl\LaravelUploadable\Interfaces\UploadFileInterface;

class CustomDriverService implements UploadFileInterface
{
    protected $disk;

    public static $uploadDir = 'uploads/';

    /**
     * __construct
     *
     * @param  \Bl\LaravelUploadable\Classes\FileArgument $disk
     * @return void
     */
    public function __construct($disk)
    {
        $this->disk = $disk->getValue();
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
        $uploadedDir = self::$uploadDir . $directory;

        return $file->storePublicly($uploadedDir);
    }

    /**
     * handle getting the file full url path.
     *
     * @param  string $path
     * @return string
     */
    public function get(string $path): mixed
    {
        return url($path);
    }

    /**
     * handle deleting a file.
     *
     * @param  string $path
     * @return void
     */
    public function delete(string $path): void
    {
        $path = storage_path('app/public/' . $path);

        if (file_exists($path)) {
            unlink($path);
        }
    }
}
