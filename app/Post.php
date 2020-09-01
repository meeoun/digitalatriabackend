<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function tags()
    {
        return $this->morphToMany(Tag::class,'taggable')->withTimestamps();
    }

    public function images()
    {
        return $this->morphToMany(Image::class,'imageable')->withTimestamps();
    }

    public function collaborators()
    {
     return $this->hasMany(Collaborator::class);
    }

    public function owner()
    {
        return $this->hasOne(User::class);
    }
}
