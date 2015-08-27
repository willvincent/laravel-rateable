<?php namespace willvincent\Rateable;

trait Rateable
{
    /**
     * This model has many ratings.
     *
     * @return Rating
     */
    public function ratings()
    {
        return $this->morphMany('willvincent\Rateable\Rating', 'rateable');
    }

    public function averageRating()
    {
        return $this->ratings()
            ->selectRaw('AVG(rating) as averageRating')
            ->pluck('averageRating');
    }

    public function ratingPercent($max = 5)
    {
        $ratings = $this->ratings();
        $quantity = $ratings->count();
        $total = $ratings->selectRaw('SUM(rating) as total')->pluck('total');
        return $total / (($quantity * $max) / 100);
    }

    public function getAverageRatingAttribute()
    {
        return $this->averageRating();
    }
}
