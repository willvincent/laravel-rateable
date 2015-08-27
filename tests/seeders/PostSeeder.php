<?php

use Illuminate\Database\Capsule\Manager as DB;

class PostSeeder
{
    public function run()
    {
        DB::table('posts')->delete();
        Post::unguard();
        Post::create(['id' => 1, 'title' => 'First post', 'body' => 'This is the first post!']);
        Post::create(['id' => 2, 'title' => 'Second post', 'body' => 'This is the second post!']);
        Post::create(['id' => 3, 'title' => 'Third post', 'body' => 'This is the third post!']);
        Post::reguard();
    }

}
