<?php

use PHPUnit\Framework\TestCase;

class RateableTestCase extends TestCase
{

    public static function setUpBeforeClass() : void
    {
        with(new UserMigrator())->up();
        with(new PostMigrator())->up();
        with(new RatingMigrator())->up();
    }

    public function setUp() : void
    {
        with(new UserSeeder())->run();
        with(new PostSeeder())->run();
        with(new RatingsSeeder())->run();
    }

}
