<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Post::class, function (Faker $faker) {
    $type = array("reviews","tutorials", "news");
    $type = $type[array_rand($type)];
    $scores =null;
    $max = null;
    $deleted = null;
    $published = null;
    if($type === "reviews")
    {
        $scores = ReviewScore::scores(5);
        $max = 10;
    }
    if(rand(1,100) > 75)
    {
        $deleted = now();
    }

    if(rand(1,100) > 75)
    {
        $published = now();
    }


    $title = $faker->unique()->jobTitle;
    return [
        'title' => $title,
        'slug' => Str::slug($title),
        'excerpt' => $faker->sentences(3,true),
        'summary' => $faker->sentences(8,true),
        'content' => $faker->sentences(40,true),
        'user_id' => User::inRandomOrder()->first()->id,
        'gallery_caption'=>"This is the main gallery caption!",
        'review_scores' => $scores,
        'max_review_score' => $max,
        'views' => rand(1,1000),
        'review_call_out' => $faker->sentences(2,true),
        'type' => $type,
        'published_at' => $published,
        'deleted_at' => $deleted,
    ];
});
