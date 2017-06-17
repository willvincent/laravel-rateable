<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('rating');
            $table->string('title')->nullable();
            $table->text('body')->nullable();
            $table->boolean('approved')->default(false);
            $table->string('ip_address', 50)->nullable();
            $table->morphs('rateable');
            $table->index('rateable_id');
            $table->index('rateable_type');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('ratings');
    }
}
