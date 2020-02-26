<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'surname' => $faker->lastName,
        'username' => "-".$faker->lastName."-".$faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'profile_picture_location' =>
            'https://www.gravatar.com/avatar/'.
            md5($faker->unique()->safeEmail).
            '?d=mm&s=40',
        'password' => '$2y$10$u.IQ6dnDfXFaZ2EN6/mcq.bojF0gCcJV4Q9cvcmchzpoqu4w0U7k2', // password
        'remember_token' => Str::random(10),
    ];
});
