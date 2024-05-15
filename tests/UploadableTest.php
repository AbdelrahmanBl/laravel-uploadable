<?php

namespace Bl\LaravelUploadable\Test;

use Illuminate\Http\Testing\FileFactory;
use Bl\LaravelUploadable\Test\User;

class LaravelUploadableTest extends TestCase
{
    public function test_it_can_update_avatar_with_default_values()
    {
        $user = User::query()->create([
            'default_avatar' => (new FileFactory)->image('avatar')
        ])->refresh();

        $avatarLink = url('storage' . DIRECTORY_SEPARATOR . $user->getRawOriginal('default_avatar'));

        $avatarPath = storage_path('app/public' . DIRECTORY_SEPARATOR . $user->getRawOriginal('default_avatar'));

        $this->assertEquals($avatarLink, $user->default_avatar);

        $this->assertFileExists($avatarPath);

        $user->delete();

        $this->assertFileDoesNotExist($avatarPath);
    }

    public function test_it_can_update_avatar_with_custom_directory()
    {
        $user = User::query()->create([
            'custom_avatar_directory' => (new FileFactory)->image('avatar')
        ])->refresh();

        $avatarLink = url('storage' . DIRECTORY_SEPARATOR . $user->getRawOriginal('custom_avatar_directory'));

        $avatarPath = storage_path('app/public' . DIRECTORY_SEPARATOR . $user->getRawOriginal('custom_avatar_directory'));

        $this->assertEquals($avatarLink, $user->custom_avatar_directory);

        $this->assertFileExists($avatarPath);

        $user->delete();

        $this->assertFileDoesNotExist($avatarPath);
    }

    public function test_it_can_update_avatar_with_custom_disk()
    {
        $user = User::query()->create([
            'custom_avatar_disk' => (new FileFactory)->image('avatar')
        ])->refresh();

        $avatarLink = '/storage' . DIRECTORY_SEPARATOR . $user->getRawOriginal('custom_avatar_disk');

        $avatarPath = storage_path('app' . DIRECTORY_SEPARATOR . $user->getRawOriginal('custom_avatar_disk'));

        $this->assertEquals($avatarLink, $user->custom_avatar_disk);

        $this->assertFileExists($avatarPath);

        $user->delete();

        $this->assertFileDoesNotExist($avatarPath);
    }

    public function test_it_can_update_avatar_with_custom_driver()
    {
        $user = User::query()->create([
            'custom_avatar_driver' => (new FileFactory)->image('avatar')
        ])->refresh();

        $avatarLink = url($user->getRawOriginal('custom_avatar_driver'));

        $avatarPath = storage_path('app/public' . DIRECTORY_SEPARATOR . $user->getRawOriginal('custom_avatar_driver'));

        $this->assertEquals($avatarLink, $user->custom_avatar_driver);

        $this->assertFileExists($avatarPath);

        $user->delete();

        $this->assertFileDoesNotExist($avatarPath);
    }

    public function test_it_can_update_avatar_with_custom_default_path()
    {
        $user = User::query()->create([
            'custom_avatar_default_path' => NULL
        ])->refresh();

        $avatarLink = url('custom_default_path.png');

        $this->assertEquals($avatarLink, $user->custom_avatar_default_path);
    }

    public function test_it_can_update_avatar_with_custom_default_path_with_nullable()
    {
        $user = User::query()->create([
            'custom_avatar_default_path_with_nullable' => NULL
        ])->refresh();

        $this->assertEquals(NULL, $user->custom_avatar_default_path_with_nullable);
    }
}
