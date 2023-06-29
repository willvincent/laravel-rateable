<?php

namespace willvincent\Rateable;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

trait Rateable
{
    /**
     * This model has many ratings.
     *
     * @param mixed $rating
     * @param mixed $value
     * @param string $comment
     *
     * @return Rating
     */

     private function byUser($user_id = null) {
        if(!! $user_id) {
            return Auth::id();
        }

         $userClass = Config::get('auth.model');
          if (is_null($userClass)) {
            $userClass = Config::get('auth.providers.users.model');
          }

        return (!! $userClass::whereId($user_id)->count())? $user_id: Auth::id();
     }
    
    public function rate($value, $comment = null, $user_id = null)
    {
        $user_id = $this->byUser($user_id);
        $rating = new Rating();
        $rating->rating = $value;
        $rating->comment = $comment;
        $rating->user_id = $user_id;

        $this->ratings()->save($rating);
    }

    public function rateOnce($value, $comment = null, $user_id = null)
    {
        $user_id = $this->byUser($user_id);
        $rating = Rating::query()
            ->where('rateable_type', '=', $this->getMorphClass())
            ->where('rateable_id', '=', $this->id)
            ->where('user_id', '=', $user_id)
            ->first()
        ;

        if ($rating) {
            $rating->rating = $value;
            $rating->comment = $comment;
            $rating->save();
        } else {
            $this->rate($value, $comment);
        }
    }

    public function ratings()
    {
        return $this->morphMany('willvincent\Rateable\Rating', 'rateable');
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }

    public function sumRating()
    {
        return $this->ratings()->sum('rating');
    }

    public function timesRated()
    {
        return $this->ratings()->count();
    }

    public function usersRated()
    {
        return $this->ratings()->groupBy('user_id')->pluck('user_id')->count();
    }

    public function userAverageRating($user_id = null)
    {
        $user_id = $this->byUser($user_id);
        return $this->ratings()->where('user_id', $user_id)->avg('rating');
    }

    public function userSumRating($user_id = null)
    {
        $user_id = $this->byUser($user_id);
        return $this->ratings()->where('user_id', $user_id)->sum('rating');
    }

    public function ratingPercent($max = 5, bool $rounded = false)
    {
        $quantity = $this->ratings()->count();
        $total = $this->sumRating();
        // return "$total || $quantity";

        $is_rounded = is_bool($rounded)? $rounded: false;
        if($rounded) {
            return ($quantity * $max) > 0 ? ceil(($total / ($quantity * $max)) * 100) : 0;
        } else { 
            return ($quantity * $max) > 0 ? $total / (($quantity * $max) / 100) : 0;
        }
    }

    // Getters

    public function getAverageRatingAttribute()
    {
        return $this->averageRating();
    }

    public function getSumRatingAttribute()
    {
        return $this->sumRating();
    }

    public function getUserAverageRatingAttribute()
    {
        return $this->userAverageRating();
    }

    public function getUserSumRatingAttribute()
    {
        return $this->userSumRating();
    }
}
