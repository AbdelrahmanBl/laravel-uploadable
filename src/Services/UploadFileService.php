<?php

namespace Bl\LaravelUploadable\Services;

use Illuminate\Support\Facades\Storage;

class UploadFileService
{
    /**
     * Delete file by it's table field name.
     *
     * @param  string $field
     * @param  array  $attributes
     * @return void
     */
    public function deleteFile(string $field, array $attributes): void
    {
        if(array_key_exists($field, $attributes) && !empty($attributes[$field])) {
            Storage::delete($attributes[$field]);
        }
    }

    /**
     * Get the specific file url or default file when not found.
     *
     * @param  string|null $path
     * @return string
     */
    public function getFileUrl(?string $path): string
    {
        return $path ? Storage::url($path) : $this->getNotfoundFile();
    }

    /**
     * Get file to display when main file is not found.
     *
     * @return string
     */
    protected function getNotfoundFile(): string
    {
        return match(get_class($this)) {
            // \App\Models\Category::class => '',
            default => asset('assets/images/icon.png')
        };
    }
}
