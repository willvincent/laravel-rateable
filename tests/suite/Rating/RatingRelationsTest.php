<?php


use willvincent\Rateable\Tests\models\Rating;
use willvincent\Rateable\Tests\TestCase;

class RatingRelationsTest extends TestCase
{
    public function testRateableIsAMorphTo()
    {
        $rating = new Rating();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\MorphTo', $rating->rateable());
    }

    public function testUserIsABelongsTo()
    {
        $rating = new Rating();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\BelongsTo', $rating->user());
    }
}
