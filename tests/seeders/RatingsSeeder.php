<?php

use Illuminate\Database\Capsule\Manager as DB;

class RatingsSeeder
{
    public function run()
    {
        DB::table('ratings')->delete();

        Rating::unguard();

        $post1 = Post::find(1);
        $post2 = Post::find(2);
        $post3 = Post::find(3);
        $user1 = User::find(1);
        $user2 = User::find(2);

        Rating::create(['id' => 1, 'rating' => 5, 'rateable_id' => $post1->id, 'rateable_type' => 'Post', 'user_id' => $user1->id]);
        Rating::create(['id' => 2, 'rating' => 5, 'rateable_id' => $post1->id, 'rateable_type' => 'Post', 'user_id' => $user2->id]);
        Rating::create(['id' => 3, 'rating' => 1, 'rateable_id' => $post2->id, 'rateable_type' => 'Post', 'user_id' => $user1->id]);
        Rating::create(['id' => 4, 'rating' => 5, 'rateable_id' => $post2->id, 'rateable_type' => 'Post', 'user_id' => $user2->id]);

        Rating::reguard();
    }
}
