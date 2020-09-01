<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Image;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\File;

$factory->define(Image::class, function (Faker $faker) {
    $base = public_path().'/upload/news-posts/';
    $array = [];
    $files = File::files($base);
    foreach ($files as $file)
    {
        array_push($array,$file->getPath().'/'.$file->getFilename());
    }
    $file = $faker->unique()->randomElement($array);
    $name = explode('/',$file);
    $name = end($name);
    $extension = explode('.',$file);
    $extension = end($extension);
    $url = "localhost/public/upload/news-posts/$name";
    return [
        "name"=>$name,
        "file_path"=>$file,
        "url"=>$url,
        "extension"=>$extension
    ];
});
