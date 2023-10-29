# laravel-uploadable
Laravel Uploadable for adding behaviour to a model for self uploading file like avatar or any file type.

## Introduction
This package can help you to upload image or any type of file to a specific destination in your filesystem, you can determine a path for a directory to save your uploaded file for each field in your table with minimal configurations or you can use the default store directory of the package.

## Installation
```
composer require abdelrahmanbl/laravel-uploadable
```
## About Upload
This package uses the [Laravel File Storage](https://laravel.com/docs/9.x/filesystem) to keep the file management. The file will be stored inside the default disk. For example, if you are using the public disk, to access the image or file, you need to create a symbolic link inside your project:
```
php artisan storage:link
```
And then, configure your default filesystem from .env file 
```
APP_URL=https://your-domain.com
FILESYSTEM_DISK=public # or your prefered disk
```
You can add `default_url` to the filesystems config file to overwrite the default file url.
The default file url is asset('uploadable.jpg').
## Usage
To use this package, import the FileCast in your model And then configure the $casts of your model with the FileCast class.
```
use Bl\LaravelUploadable\Casts\FileCast;

class User extends model 
{
    /**
     * Don't forget 
     * Add all the fields for file or image to the model $fillable when you don't use model $guarded.
     *
     * @var array
     */
    protected $fillable = [
        ...,
        'avatar', 
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        ...,
        'avatar' => FileCast::class,
    ];
}
```
## Customize The Directory
```
'avatar' => FileCast::class . ':User/avatar', # this is the default value ( the attribute key name inside the model basename ) 
```
## Customize The Disk
```
'avatar' => FileCast::class . ':default,s3', # here we customized the disk to s3. 
```
## Customize The Driver
```
'avatar' => FileCast::class . ':default,default,' . CustomDriverService::class, 
```
Note: your customer driver service must implement `Bl\LaravelUploadable\Interfaces\UploadFileInterface`
and has a constructor with parameter $disk
```
use Bl\LaravelUploadable\Interfaces\UploadFileInterface;
use Illuminate\Http\UploadedFile;

class CustomDriverService implements UploadFileInterface
{
    protected $disk;

    public function __construct($disk = '')
    {
        $this->disk = $disk;
    }

    public function get(?string $path): mixed
    {
        // ...
    }

    public function store(UploadedFile $file, string $directory): mixed
    {
        // ...
    }

    public function delete(?string $path): void
    {
        // ...
    }
}
```
That's all! After this configuration, you can send file data from the client side with the same name of each file field of the model. The package will make the magic!
## Example
In frontend you can create a form-data with field name avatar.

```
<form method="POST" action="" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="file">File</label>
        <input type="file" name="avatar" id="file">
    </div>
    <div>
        <button>
            Submit
        </button>
    </div>
</form>
```
In backend you can pass all the data to the User model.
```
$data = $request->validated(); // or you can use $request->all() if you dont make a validation
$user = \App\Models\User::query()->create($data);

$user->avatar # this get a link of image that uploaded.
```
You can update the file manually to the User model.
```
$user = \App\Models\User::query()->first();
$user->avatar = $request->file('avatar');
$user->save();

$user->avatar # this get a link of image that uploaded.
```
Note: when update a field with a file the package will automatic delete the old file and put the new one.
## Delete The File
You can use either the package driver service or your custom driver service to delete the file.
```
$user = \App\Models\User::query()->first();
$avatar = $user->getRawOriginal('avatar');
(new DriverService)->delete($avatar); # delete the user's avatar file
$user->delete(); # delete the user
```
## Contributing
Feel free to comment, open issues and send PR's. Enjoy it!!
## License
BL
