<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected  $hidden =[
        'pivot',
        'laravel_through_key'
    ];
    //

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    public function users()
    {
        return $this->morphedByMany(User::class,'taggable');
    }
}
