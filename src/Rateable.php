<?php

namespace willvincent\Rateable;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

     private function byUser($userId = null) {
        $user = Auth::id();
        try {
            $newUser = User::find($userId);
            if(!is_null($newUser)) {
                $user = $newUser->id;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        return $user;
     }
    public function rate($value, $comment = null, $userId = null)
    {
        $user_id = $this->byUser($userId);
        $rating = new Rating();
        $rating->rating = $value;
        $rating->comment = $comment;
        $rating->user_id = $user_id;

        $this->ratings()->save($rating);
    }

    public function rateOnce($value, $comment = null, $userId = null)
    {
        $user_id = $this->byUser($userId);
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

    public function userAverageRating($userId = null)
    {
        $user_id = $this->byUser($userId);
        return $this->ratings()->where('user_id', $user_id)->avg('rating');
    }

    public function userSumRating($userId = null)
    {
        $user_id = $this->byUser($userId);
        return $this->ratings()->where('user_id', $user_id)->sum('rating');
    }

    public function ratingPercent($max = 5)
    {
        $quantity = $this->ratings()->count();
        $total = $this->sumRating();
        // return "$total || $quantity";

        return ($quantity * $max) > 0 ? ceil(($total / ($quantity * $max)) * 100) : 0;
        // return ($quantity * $max) > 0 ? $total / (($quantity * $max) / 100) : 0;
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
