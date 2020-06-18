<?php

namespace willvincent\Rateable\Tests\models;

use Illuminate\Database\Eloquent\Model;
use willvincent\Rateable\Rateable;

class Post extends Model
{
    use Rateable;

    public $fillable = ['title', 'body'];

    public function ratings()
    {
        return $this->morphMany('willvincent\Rateable\Tests\models\Rating', 'rateable');
    }
}
