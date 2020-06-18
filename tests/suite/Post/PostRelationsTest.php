<?php

namespace willvincent\Rateable\Tests\suite\Post;

use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use willvincent\Rateable\Tests\models\Post;
use willvincent\Rateable\Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class PostRelationsTest extends TestCase
{
    use DatabaseTransactions;

    public function testRatingsIsAMorphMany()
    {
        $post = new Post();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\MorphMany', $post->ratings());
    }

    public function testRatingsReturnRelatedRatings()
    {
        $post1 = Post::find(1);
        $post2 = Post::find(2);

        $this->be(User::find(1));
        $post1->rate(5);
        $post2->rate(1);

        $this->be(User::find(2));
        $post1->rate(5);
        $post2->rate(5);

        $this->assertEquals(2, $post1->ratings()->count());
        $this->assertEquals(2, $post2->ratings()->count());
    }

    public function testRatingsAverageRating()
    {
        $post1 = Post::find(1);
        $post2 = Post::find(2);

        $this->be(User::find(1));
        $post1->rate(5);
        $post2->rate(1);

        $this->be(User::find(2));
        $post1->rate(5);
        $post2->rate(5);

        $this->assertEquals(5.0, $post1->averageRating);
        $this->assertEquals(3.0, $post2->averageRating);
    }

    public function testRatingsRatingPercent()
    {
        $post1 = Post::find(1);
        $post2 = Post::find(2);

        $this->be(User::find(1));
        $post1->rate(5);
        $post2->rate(1);

        $this->be(User::find(2));
        $post1->rate(5);
        $post2->rate(5);

        // Post 1 should have a perfect 100% rating
        $this->assertEquals(100, $post1->ratingPercent());

        // But if we say that 10 stars are allowed, its rating
        // should drop to 50%
        $this->assertEquals(50, $post1->ratingPercent(10));

        // Post 2 should have a 60% rating
        $this->assertEquals(60, $post2->ratingPercent());

        // But if we say that 10 stars are allowed, its rating
        // should drop to 30%
        $this->assertEquals(30, $post2->ratingPercent(10));
    }

    public function testPlusOneStyleRatings()
    {
        $post = Post::find(3);

        $this->assertEquals(0, $post->sumRating);
        $this->assertEquals(0, $post->sumRating());
        $this->assertEquals(0, $post->ratings()->count());

        $this->be(User::find(1));
        $post->rate(1);

        $this->assertEquals(1, $post->sumRating);
        $this->assertEquals(1, $post->sumRating());
        $this->assertEquals(1, $post->ratings()->count());

        $this->be(User::find(2));
        $post->rate(-1);

        $this->assertEquals(0, $post->sumRating);
        $this->assertEquals(0, $post->sumRating());
        $this->assertEquals(2, $post->ratings()->count());
        $this->assertEquals(2, $post->usersRated());
    }

    public function testUsersCanRateOnlyOnce()
    {
        $post = Post::find(1);

        $this->assertEquals(0, $post->ratings()->count());

        $this->be(User::find(1));
        $post->rateOnce(3);

        $this->assertEquals(3, $post->sumRating);
        $this->assertEquals(1, $post->ratings()->count());

        $this->be(User::find(1));
        $post->rateOnce(5);

        $this->assertEquals(5, $post->sumRating);
        $this->assertEquals(1, $post->ratings()->count());
        $this->assertEquals(1, $post->usersRated());
    }
}
