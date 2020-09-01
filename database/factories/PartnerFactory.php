<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Partner;
use App\User;
use Faker\Generator as Faker;

$factory->define(Partner::class, function (Faker $faker) {
    $users = User::all();
    $user = $faker->unique()->randomElement($users);
    $partner = $faker->unique()->randomElement($users);
    return [
        "user_id"=>$user->id,
        "partner_id"=>$partner->id
    ];
});
