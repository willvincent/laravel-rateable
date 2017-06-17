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

    public function users()
    {
        return $this->hasMany('willvincent\Rateable\Rating', 'user_id');
    }

    public function averageRating($round = null)
    {
        $rating = $this->ratings()->where('approved', TRUE)->avg('rating');
        if ($round !== null) {
            // round(3.6);          4
            // round(3.6, 0);       4
            // round(1.95583, 2);   1.96
            $rating = round($rating, $round);
        }
        return $rating;
    }

    public function sumRating()
    {
        return $this->ratings()->where('approved', TRUE)->sum('rating');
    }

    public function getRatings()
    {
        return $this->ratings()->where('approved', TRUE)->get();
    }

    public function userAverageRating()
    {
        return $this->ratings()->where('approved', TRUE)->where('user_id', \Auth::id())->avg('rating');
    }

    public function userSumRating()
    {
        return $this->ratings()->where('approved', TRUE)->where('user_id', \Auth::id())->sum('rating');
    }

    public function userRatings()
    {
        return $this->users()->where('approved', TRUE)->where('user_id', \Auth::id())->get();
    }

    public function ratingPercent($max = 5)
    {
        $quantity = $this->ratings()->where('approved', TRUE)->count();
        $total = $this->sumRating();

        return ($quantity * $max) > 0 ? $total / (($quantity * $max) / 100) : 0;
    }

    public function getAverageRatingAttribute()
    {
        return $this->averageRating();
    }

    public function getSumRatingAttribute()
    {
        return $this->sumRating();
    }

    public function getUserRatingsAttribute()
    {
        return $this->userRatings();
    }

    public function getUserAverageRatingAttribute()
    {
        return $this->userAverageRating();
    }

    public function getUserSumRatingAttribute()
    {
        return $this->userSumRating();
    }

    public function getRatingsAttribute()
    {
        return $this->getRatings();
    }

}
