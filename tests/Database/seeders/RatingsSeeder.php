<?php

namespace willvincent\Rateable\Tests\Database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use willvincent\Rateable\Tests\models\Post;
use willvincent\Rateable\Tests\models\User;

class RatingsSeeder extends Seeder
{
    public function run()
    {
        DB::table('ratings')->delete();

        $post1 = Post::find(1);
        $post2 = Post::find(2);
        $post3 = Post::find(3);

        $user1 = User::find(1);
        $user2 = User::find(2);


        Auth::loginUsingId(1);
        $post1->rate(5);
        $post2->rate(1);

        Auth::loginUsingId(2);
        $post1->rate(5);
        $post2->rate(5);
    }
}
