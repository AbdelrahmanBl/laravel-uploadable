<?php

namespace Bl\LaravelUploadable\Services;

use Bl\LaravelUploadable\Interfaces\UploadFileInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PublicDriverService implements UploadFileInterface
{
    protected $disk = 'public';

    /**
     * handle store proccess of the file.
     *
     * @param  UploadedFile $file
     * @param  string $dir
     * @return mixed
     */
    public function store(UploadedFile $file, string $dir): mixed
    {
        return $file->store($dir, $this->disk);
    }

    /**
     * handle getting the file full url path.
     *
     * @param  string|null $path
     * @return string
     */
    public function get(?string $path): string
    {
        return Storage::disk($this->disk)->url($path);
    }

    /**
     * handle deleting a file.
     *
     * @param  string $key
     * @param  array  $attributes
     * @return void
     */
    public function delete(string $key, array $attributes): void
    {
        if(array_key_exists($key, $attributes) && !empty($attributes[$key])) {

            Storage::disk($this->disk)->delete($attributes[$key]);

        }
    }
}
