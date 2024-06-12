<?php

namespace Bl\LaravelUploadable\Test\Models;

use Illuminate\Database\Eloquent\Model;
use Bl\LaravelUploadable\Casts\FileCast;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class GlobalEventModel extends Model
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
        'default_avatar' => FileCast::class,
    ];

    /**
     * apply before file cast upload event.
     *
     * @param  UploadedFile $file
     * @return UploadedFile
     */
    public function beforeFileCastUpload(UploadedFile $file): UploadedFile
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
     * apply after file cast upload event.
     *
     * @param  UploadedFile $file
     * @return void
     */
    public function afterFileCastUpload(UploadedFile $file): void
    {
        session()->put('GLOBAL_UPLOADED_FILE_PATH', $file->path());
    }
}
