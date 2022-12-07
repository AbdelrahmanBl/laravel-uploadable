# laravel-uploadable
Laravel Uploadable for adding behaviour to a model for self uploading images like avatar or any files type.

## Introduction
This package can help you to upload images or any type of files to a detination in your filesystem, you can determine a path for a directory to save your uploaded file for each field in your table with minimal configurations.

## Installation
```
composer require AbdelrahmanBl/laravel-uploadable
```
## About Upload
This package uses the [Laravel File Storage](https://laravel.com/docs/9.x/filesystem) to keep the file management. The files will be stored inside the default disk. For example, if you are using the public disk, to access the images or files, you need to create a symbolic link inside your project:
```
php artisan storage:link
```
And then, configure your default filesystem, inside config/filesystems.php to point the public disk:
```
'default' => env('FILESYSTEM_DRIVER', 'public'),
```
Or you can configure your default filesystem, from .env file 
```
FILESYSTEM_DRIVER=public
```
