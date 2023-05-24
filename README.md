# laravel-uploadable
Laravel Uploadable for adding behaviour to a model for self uploading images like avatar or any files type.

## Introduction
This package can help you to upload images or any type of files to a destination in your filesystem, you can determine a path for a directory to save your uploaded file for each field in your table with minimal configurations.

## Installation
```
composer require abdelrahmanbl/laravel-uploadable
```
## About Upload
This package uses the [Laravel File Storage](https://laravel.com/docs/10.x/filesystem) to keep the file management. The files will be stored inside the default disk. For example, if you are using the public disk, to access the images or files, you need to create a symbolic link inside your project:
```
php artisan storage:link  # this command is only when public disk driver configuration
```
And then, configure your default filesystem, from .env file 
```
APP_URL=https://your-domain.com
FILESYSTEM_DISK=public # public|local|s3
```
## Usage
To use this package, import the HasUploadable trait in your model:
And then, configure your uploadable fields for images and files inside your model.
```
use Bl\LaravelUploadable\Casts\FileCast;

class User extends model 
{
    /**
     * add all fields for files or images to model $fillable when you don't use model $guarded.
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
Note: You can customize the store directory by adding concatination and ':' operator then your custom directory.
like this
```
'avatar' => FileCast::class . ':User/avatar', # this is the default value ( model basename / attribute key name  ).
```
Note: You can customize the disk driver store by adding concatination and ',' operator then your custom disk.
```
'avatar' => FileCast::class . ':default,s3', # when you don't want to use the default disk you can assign it. 
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
In backend you can pass all the validated data to the User model.
```
$user = \App\Models\User::query()->create($request->validated());

$user->avatar # this get a link of image that uploaded.
```
Or you can set the data manually to the User model.
```
$user = \App\Models\User::query()->create([
    'avatar'    => $request->file('avatar')
]);

$user->avatar # this get a link of image that uploaded.
```
## Contributing
Feel free to comment, open issues and send PR's. Enjoy it!!
## License
BL
