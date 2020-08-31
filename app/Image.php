<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'imageable');
    }


    public function users()
    {
        return $this->morphedByMany(User::class, 'imageable');
    }

}
