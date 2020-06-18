<?php

namespace willvincent\Rateable\Tests\models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    public $fillable = ['rating'];

    public function rateable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
