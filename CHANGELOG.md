# Changelog

All notable changes to `laravel-rateable` will be documented in this file


## 2.2.0

- Refactor codebase to be based on spatie's [package-skeleton-laravel](https://github.com/spatie/package-skeleton-laravel)
- Add new `rate()` and `rateOnce()` methods to simplify rating, and facilitate restricting users to one rating per model
- Add new `timesRated()` and `usersRated()` methods to get counts of total ratings or unique users' ratings for a model


## 2.1.0

- @Mo7sin - Laravel 7 support


## 2.0.0

- @khanhvu14 - Laravel 6 support


## 1.0.9

- @Devsome - Fix migration error


## 1.0.8

- Prevent duplicate migration files if the rateable:migration command is run multiple times


## 1.0.7

Redacted


## 1.0.6

- @mattstauffer - Allow for Laravel Service Provider autodiscovery (#27)
- @mattstauffer - Readme cleanup (#28)


## 1.0.5

- @mkwsra - Fix user relations


## 1.0.4

- @nghtstr & @willvincent - Added sum and average attributes


## 1.0.3

- Fixes critical call to undefined method bindShared() error in Laravel 5.2+


## 1.0.2

- @zOxta - Added protection for division by zero


## 1.0.1

- Test +1/-1 format ratings.


## 1.0.0

- initial release
