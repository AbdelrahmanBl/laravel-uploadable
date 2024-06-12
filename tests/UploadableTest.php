<?php

namespace Bl\LaravelUploadable\Test;

use Bl\LaravelUploadable\Test\Models\CustomEventModel;
use Bl\LaravelUploadable\Test\Models\GlobalEventModel;
use Bl\LaravelUploadable\Test\Models\OverwriteEventModel;
use Bl\LaravelUploadable\Test\Models\User;
use Illuminate\Http\UploadedFile;

class LaravelUploadableTest extends TestCase
{
    public function test_it_can_create_avatar_with_default_values()
    {
        $user = User::query()->create([
            'default_avatar' => UploadedFile::fake()->image('avatar')
        ]);

        $avatarLink = url('storage' . DIRECTORY_SEPARATOR . $user->getRawOriginal('default_avatar'));

        $avatarPath = storage_path('app/public' . DIRECTORY_SEPARATOR . $user->getRawOriginal('default_avatar'));

        $this->assertEquals($avatarLink, $user->default_avatar);

        $this->assertFileExists($avatarPath);

        $user->delete();

        $this->assertFileDoesNotExist($avatarPath);
    }

    public function test_it_can_create_avatar_with_custom_directory()
    {
        $user = User::query()->create([
            'custom_avatar_directory' => UploadedFile::fake()->image('avatar')
        ]);

        $avatarLink = url('storage' . DIRECTORY_SEPARATOR . $user->getRawOriginal('custom_avatar_directory'));

        $avatarPath = storage_path('app/public' . DIRECTORY_SEPARATOR . $user->getRawOriginal('custom_avatar_directory'));

        $this->assertEquals($avatarLink, $user->custom_avatar_directory);

        $this->assertFileExists($avatarPath);

        $user->delete();

        $this->assertFileDoesNotExist($avatarPath);
    }

    public function test_it_can_create_avatar_with_custom_disk()
    {
        $user = User::query()->create([
            'custom_avatar_disk' => UploadedFile::fake()->image('avatar')
        ]);

        $avatarLink = '/storage' . DIRECTORY_SEPARATOR . $user->getRawOriginal('custom_avatar_disk');

        $avatarPath = storage_path('app' . DIRECTORY_SEPARATOR . $user->getRawOriginal('custom_avatar_disk'));

        $this->assertEquals($avatarLink, $user->custom_avatar_disk);

        $this->assertFileExists($avatarPath);

        $user->delete();

        $this->assertFileDoesNotExist($avatarPath);
    }

    public function test_it_can_create_avatar_with_custom_driver()
    {
        $user = User::query()->create([
            'custom_avatar_driver' => UploadedFile::fake()->image('avatar')
        ]);

        $avatarLink = url($user->getRawOriginal('custom_avatar_driver'));

        $avatarPath = storage_path('app/public' . DIRECTORY_SEPARATOR . $user->getRawOriginal('custom_avatar_driver'));

        $this->assertEquals($avatarLink, $user->custom_avatar_driver);

        $this->assertFileExists($avatarPath);

        $user->delete();

        $this->assertFileDoesNotExist($avatarPath);
    }

    public function test_it_can_create_avatar_with_custom_default_path()
    {
        $user = User::query()->create([
            'custom_avatar_default_path' => NULL
        ]);

        $avatarLink = url('custom_default_path.png');

        $this->assertEquals($avatarLink, $user->custom_avatar_default_path);
    }

    public function test_it_can_create_avatar_with_custom_default_path_with_nullable()
    {
        $user = User::query()->create([
            'custom_avatar_default_path_with_nullable' => NULL
        ]);

        $this->assertEquals(NULL, $user->custom_avatar_default_path_with_nullable);
    }

    public function test_it_can_overwrite_old_avatar_when_updating()
    {
        $user = User::query()->create([
            'default_avatar' => UploadedFile::fake()->image('avatar')
        ]);

        $oldAvatarLink = url('storage' . DIRECTORY_SEPARATOR . $user->getRawOriginal('default_avatar'));

        $oldAvatarPath = storage_path('app/public' . DIRECTORY_SEPARATOR . $user->getRawOriginal('default_avatar'));

        $this->assertFileExists($oldAvatarPath);

        $user->update([
            'default_avatar' => UploadedFile::fake()->image('avatar')
        ]);

        $newAvatarLink = url('storage' . DIRECTORY_SEPARATOR . $user->getRawOriginal('default_avatar'));

        $newAvatarPath = storage_path('app/public' . DIRECTORY_SEPARATOR . $user->getRawOriginal('default_avatar'));

        $this->assertNotEquals($oldAvatarLink, $newAvatarLink);

        $this->assertFileDoesNotExist($oldAvatarPath);

        $this->assertFileExists($newAvatarPath);

        $user->delete();

        $this->assertFileDoesNotExist($newAvatarPath);
    }

    public function test_it_can_apply_global_events()
    {
        $image = UploadedFile::fake()->image('avatar');

        $user = GlobalEventModel::query()->create([
            'default_avatar' => $image,
        ]);

        $avatarPath = storage_path('app/public' . DIRECTORY_SEPARATOR . $user->getRawOriginal('default_avatar'));

        $this->assertLessThan($image->getSize(), filesize($avatarPath));

        $this->assertFileEquals($avatarPath, session()->pull('GLOBAL_UPLOADED_FILE_PATH'));
    }

    public function test_it_can_apply_custom_events()
    {
        $image = UploadedFile::fake()->image('avatar');

        $user = CustomEventModel::query()->create([
            'default_avatar' => $image,
        ]);

        $avatarPath = storage_path('app/public' . DIRECTORY_SEPARATOR . $user->getRawOriginal('default_avatar'));

        $this->assertLessThan($image->getSize(), filesize($avatarPath));

        $this->assertFileEquals($avatarPath, session()->pull('CUSTOM_UPLOADED_FILE_PATH'));
    }

    public function test_it_can_apply_custom_overwrite_global_events()
    {
        $image = UploadedFile::fake()->image('avatar');

        $user = OverwriteEventModel::query()->create([
            'default_avatar' => $image,
        ]);

        $avatarPath = storage_path('app/public' . DIRECTORY_SEPARATOR . $user->getRawOriginal('default_avatar'));

        $this->assertLessThan($image->getSize(), filesize($avatarPath));

        $this->assertNull(session()->pull('GLOBAL_UPLOADED_FILE_PATH'));

        $this->assertFileEquals($avatarPath, session()->pull('CUSTOM_UPLOADED_FILE_PATH'));
    }
}
