<?php

use Illuminate\Database\Capsule\Manager as DB;

class UserSeeder
{

    public function run()
    {
        DB::table('users')->delete();
        User::unguard();
        User::create(['id' => 1]);
        User::create(['id' => 2]);
        User::reguard();
    }

}
