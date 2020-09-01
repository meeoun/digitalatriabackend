<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Collaborator;
use App\Post;
use Faker\Generator as Faker;
use App\User;
$factory->define(Collaborator::class, function (Faker $faker) {
    $user = User::inRandomOrder()->first();
    $posts = Post::all();

    return [
        "user_id"=>$user->id,
        "post_id"=>$faker->unique()->randomElement($posts)->id
    ];
});
