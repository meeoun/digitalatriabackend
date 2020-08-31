<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Post::class, function (Faker $faker) {
    $type = array("review","tutorial", "news");
    $type = $type[array_rand($type)];
    $scores =null;
    $max = null;
    $deleted = null;
    if($type === "review")
    {
        $scores = ReviewScore::scores(5);
        $max = 10;
    }
    if(rand(1,100) > 75)
    {
        $deleted = now();
    }


    $title = $faker->unique()->jobTitle;
    return [
        'title' => $title,
        'slug' => Str::slug($title),
        'excerpt' => $faker->sentences(3,true),
        'summary' => $faker->sentences(8,true),
        'content' => $faker->sentences(40,true),
        'user_id' => User::inRandomOrder()->first()->id,
        'review_scores' => $scores,
        'max_review_score' => $max,
        'views' => rand(1,1000),
        'review_call_out' => $faker->sentences(2,true),
        'type' => $type,
        'published_at' => now(),
        'deleted_at' => $deleted,
    ];
});