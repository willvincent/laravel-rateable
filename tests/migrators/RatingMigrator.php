<?php

use Illuminate\Database\Capsule\Manager as DB;

class RatingMigrator
{

    public function up()
    {
        DB::schema()->dropIfExists('ratings');
        DB::schema()->create('ratings', function ($table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('rating');
            $table->morphs('rateable');
            $table->integer('user_id')->unsigned();
            $table->index('user_id');
            $table->index('rateable_id');
            $table->index('rateable_type');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        DB::schema()->drop('ratings');
    }

}
