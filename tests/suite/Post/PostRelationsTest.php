<?php

class PostRelationsTest extends RateableTestCase
{

    public function testRatingsIsAMorphMany()
    {
        $post = new Post();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\MorphMany', $post->ratings());
    }

    public function testRatingsReturnRelatedRatings()
    {
        $post1 = Post::find(1);
        $post2 = Post::find(2);

        $this->assertEquals(2, $post1->ratings()->count());
        $this->assertEquals(2, $post2->ratings()->count());
    }

    public function testRatingsAverageRating()
    {
        $post1 = Post::find(1);
        $post2 = Post::find(2);

        $this->assertEquals(5.0, $post1->averageRating);
        $this->assertEquals(3.0, $post2->averageRating);
    }

    public function testRatingsRatingPercent()
    {
        $post1 = Post::find(1);
        $post2 = Post::find(2);

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

        $rating = new willvincent\Rateable\Rating;
        $rating->rating = 1;
        $rating->user_id = 1;
        $post->ratings()->save($rating);

        $this->assertEquals(1, $post->sumRating);
        $this->assertEquals(1, $post->sumRating());

        $rating = new willvincent\Rateable\Rating;
        $rating->rating = -1;
        $rating->user_id = 2;
        $post->ratings()->save($rating);

        $this->assertEquals(0, $post->sumRating);
        $this->assertEquals(0, $post->sumRating());
    }
}
