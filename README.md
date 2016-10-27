# Laravel Rateable

[![Build Status](https://travis-ci.org/willvincent/laravel-rateable.svg?branch=master)](https://travis-ci.org/willvincent/laravel-rateable)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/08d52e5f-e13b-42db-bf3f-821d4005e6a6.svg?style=flat-square)](https://insight.sensiolabs.com/projects/08d52e5f-e13b-42db-bf3f-821d4005e6a6)
[![Latest Stable Version](https://poser.pugx.org/willvincent/laravel-rateable/v/stable.svg)](https://packagist.org/packages/willvincent/laravel-rateable) [![License](https://poser.pugx.org/willvincent/laravel-rateable/license.svg)](https://packagist.org/packages/willvincent/laravel-rateable)

[![Total Downloads](https://poser.pugx.org/willvincent/laravel-rateable/downloads.svg)](https://packagist.org/packages/willvincent/laravel-rateable) [![Monthly Downloads](https://poser.pugx.org/willvincent/laravel-rateable/d/monthly.png)](https://packagist.org/packages/willvincent/laravel-rateable) [![Daily Downloads](https://poser.pugx.org/willvincent/laravel-rateable/d/daily.png)](https://packagist.org/packages/willvincent/laravel-rateable)

Provides a trait to allow rating of multiple models within your app for Laravel 5.

Ratings could be fivestar style, or simple +1/-1 style.

# Installation
Edit your project's composer.json file to require `willvincent/laravel-rateable`.
````
"require": {
  "willvincent/laravel-rateable": "~1.0"
}
````

Next, update Composer from the terminal.
````
composer update
````

As with most Laravel packages you'll need to register Rateable *service provider*. In your `config/app.php` add `'willvincent\Rateable\RateableServiceProvider'` to the end of the `$providers` array.
````php
'providers' => [

    Illuminate\Foundation\Providers\ArtisanServiceProvider::class,
    Illuminate\Auth\AuthServiceProvider::class,
    ...
    willvincent\Rateable\RateableServiceProvider::class,

],
````

# Getting started
After the package is correctly installed, you need to generate the migration.
````
php artisan rateable:migration
````

It will generate the `<timestamp>_create_ratings_table.php` migration. You may now run it with the artisan migrate command:
````
php artisan migrate
````

After the migration, one new table will be present, `ratings`.

# Usage
You need to set on your model that it is rateable.
````php
<?php namespace App;

use willvincent\Rateable\Rateable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    use Rateable;

}
````

Now, your model has access to a few additional methods.

First, to add a rating to your model:
````php
$post = Post::first();

$rating = new willvincent\Rateable\Rating;
$rating->rating = 5;
$rating->user_id = \Auth::id();

$post->ratings()->save($rating);

dd(Post::first()->ratings);
````

Once a model has some ratings, you can fetch the average rating:
````php
$post = Post::first();

dd($post->averageRating);
// $post->averageRating() also works for this.
````

Also, you can fetch the rating percentage. This is also how you enforce a maximum rating value.
````php
$post = Post::first();

dd($post->ratingPercent(10)); // Ten star rating system
// Note: The value passed in is treated as the maximum allowed value.
// This defaults to 5 so it can be called without passing a value as well.

// $post->ratingPercent(5) -- Five star rating system totally equivilent to:
// $post->ratingPercent()
````

You can also fetch the sum or average of ratings for the given rateable item the current (authorized) has voted/rated.
````php
$post = Post::first();

// These values depend on the user being logged in,
// they use the Auth facade to fetch the current user's id.


dd($post->userAverageRating); 

dd($post->userSumRating);
````
