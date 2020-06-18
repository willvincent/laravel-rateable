<?php

use Illuminate\Foundation\Auth\User;
use willvincent\Rateable\Tests\models\Post;
use willvincent\Rateable\Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class UserRatingsTest extends TestCase
{
    public function testUserAverageRating()
    {
        $post1 = Post::find(1);
        $post2 = Post::find(2);

        $this->be(User::find(1));
        $post1->rate(1);
        $post2->rate(3);

        $this->assertEquals(1, (int) Post::find(1)->ratings()->count());
        $this->assertEquals(1, (int) Post::find(1)->userAverageRating);
        $this->assertEquals('1.0', Post::find(1)->userAverageRating());

        $this->assertEquals(1, (int) Post::find(2)->ratings()->count());
        $this->assertEquals(3, (int) Post::find(2)->userAverageRating);
        $this->assertEquals('3.0', Post::find(2)->userAverageRating());
    }

    public function testUserSumRating()
    {
        $post1 = Post::find(1);
        $post2 = Post::find(2);

        $this->be(User::find(1));

        $post1->rate(5);
        $post2->rate(4);

        $this->assertEquals(1, (int) Post::find(1)->ratings()->count());
        $this->assertEquals(5, Post::find(1)->userSumRating);
        $this->assertEquals(5, Post::find(1)->userSumRating());

        $this->assertEquals(1, (int) Post::find(2)->ratings()->count());
        $this->assertEquals(4, Post::find(2)->userSumRating);
        $this->assertEquals(4, Post::find(2)->userSumRating());
    }
}
