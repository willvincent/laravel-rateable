<?php

namespace willvincent\Rateable\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use willvincent\Rateable\RateableServiceProvider;
use willvincent\Rateable\Tests\Database\migrations\PostMigrator;
use willvincent\Rateable\Tests\Database\migrations\RatingMigrator;
use willvincent\Rateable\Tests\Database\migrations\UserMigrator;
use willvincent\Rateable\Tests\Database\seeders\PostSeeder;
use willvincent\Rateable\Tests\Database\seeders\RatingsSeeder;
use willvincent\Rateable\Tests\Database\seeders\UserSeeder;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        (new UserSeeder())->run();
        (new PostSeeder())->run();
        // (new RatingsSeeder())->run();
    }

    protected function getPackageProviders($app)
    {
        return [
            RateableServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        (new UserMigrator())->up();
        (new PostMigrator())->up();
        (new RatingMigrator())->up();
    }
}
