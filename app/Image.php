<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

    protected $fillable = [
        'name',
        'description',

        ];

    protected  $hidden =[
        'pivot',
        'laravel_through_key'
    ];
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'imageable');
    }


    public function users()
    {
        return $this->morphedByMany(User::class, 'imageable');
    }

}
