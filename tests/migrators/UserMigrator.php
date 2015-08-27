<?php

use Illuminate\Database\Capsule\Manager as DB;

class UserMigrator
{

    public function up()
    {
        DB::schema()->dropIfExists('users');
        DB::schema()->create('users', function ($table) {
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down()
    {
        DB::schema()->drop('users');
    }

}
