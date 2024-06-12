<?php

namespace Bl\LaravelUploadable\Test\Services;

use Bl\LaravelUploadable\Interfaces\EventUploadInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CustomUploadService implements EventUploadInterface
{
    /**
     * Apply before the file cast upload event.
     *
     * @param  UploadedFile $file
     * @return UploadedFile
     */
    public function before(UploadedFile $file): UploadedFile
    {
        $compressedFile = gzencode(file_get_contents($file), 9);

        // Save the compressed content to a temporary file
        $tempFilePath = tempnam(sys_get_temp_dir(), 'compressed');
        file_put_contents($tempFilePath, $compressedFile);

        // Determine the MIME type of the original file
        $mimeType = Storage::mimeType($tempFilePath);

        // Create UploadedFile instance
        $uploadedFile = new UploadedFile(
            $tempFilePath,
            $file->getClientOriginalName(),
            $mimeType,
            null,
            true // Mark the file as already uploaded
        );

        return $uploadedFile;
    }

    /**
     * Apply after the file cast upload event.
     *
     * @param  UploadedFile $file
     * @return void
     */
    public function after(UploadedFile $file): void
    {
        session()->put('CUSTOM_UPLOADED_FILE_PATH', $file->path());
    }
}
