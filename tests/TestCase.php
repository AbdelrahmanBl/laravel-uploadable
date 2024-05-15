<?php

namespace Bl\LaravelUploadable\Test;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Schema;
use \Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        $this->migrate();
    }

    protected function migrate()
    {
        Schema::create('users', function(Blueprint $table) {
            $table->id();
            $table->string('default_avatar')->nullable();
            $table->string('custom_avatar_directory')->nullable();
            $table->string('custom_avatar_disk')->nullable();
            $table->string('custom_avatar_driver')->nullable();
            $table->string('custom_avatar_default_path')->nullable();
            $table->string('custom_avatar_default_path_with_nullable')->nullable();
        });
    }
}
