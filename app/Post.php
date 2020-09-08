<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected  $hidden =[
        'pivot',
        'laravel_through_key'
    ];
    protected $appends = ['publish_time'];

    public function getpublishTimeAttribute()
    {
        $date = \Carbon\Carbon::parse($this->published_at);
        return  $date->format('h:i A');;
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class,'taggable')->withTimestamps();
    }

    public function images()
    {
        return $this->morphToMany(Image::class,'imageable')->withTimestamps()->withPivot(['id','caption', 'position']);
    }


    public function owner()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }


    public function collaborators()
    {
        return $this->hasManyThrough(User::class, Collaborator::class, 'post_id','id','id','user_id');

    }

    public function partners()
    {
        return $this->hasManyThrough(User::class, Partner::class, 'user_id','id','user_id','partner_id');
    }

    public function userHasAccess(User $user)
    {
        if($this->owner->contains($user))
        {
            return true;
        }elseif ($this->collaborators->contains($user))
        {
            return true;
        }elseif ($this->partners->contains($user))
        {
            return true;
        }
        else{
            return false;
        }

    }
}
