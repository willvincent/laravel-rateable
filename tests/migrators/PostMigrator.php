<?php

use Illuminate\Database\Capsule\Manager as DB;

class PostMigrator
{

    public function up()
    {
        DB::schema()->dropIfExists('posts');
        DB::schema()->create('posts', function ($table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('title');
            $table->text('body');
        });
    }

    public function down()
    {
        DB::schema()->drop('posts');
    }

}
