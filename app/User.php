<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'pivot', 'laravel_through_key'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tags()
    {
        return $this->morphToMany(Tag::class,'taggable')->withTimestamps();
    }


    public function images()
    {
        return $this->morphToMany(Image::class,'imageable')->withTimestamps();
    }


    public function partners()
    {
        return $this->hasManyThrough(User::class, Partner::class,'user_id','id', 'id', 'partner_id' );
    }


    public function partneredWith()
    {
        return $this->hasManyThrough(User::class, Partner::class,'partner_id','id', 'id', 'user_id' );
    }


    public function posts()
    {
        return $this->hasMany(Post::class);
    }


    public function partnerPosts(){
        return $this->hasManyThrough(Post::class, Partner::class,'user_id','user_id', 'id', 'partner_id' );
    }


    public function partneredWithPosts()
    {
        return $this->hasManyThrough(Post::class, Partner::class,'partner_id','user_id', 'id', 'user_id' );
    }


    public function collaboratorPosts()
    {
        return $this->hasManyThrough(Post::class, Collaborator::class,'user_id','id', 'id', 'post_id' );
    }

    public function hasPostAccess(Post $post)
    {
        if($this->posts->contains($post))
        {
            return true;
        }elseif ($this->partneredWithPosts->contains($post))
        {
            return true;
        }elseif($this->partnerPosts->contains($post))
        {
            return true;
        }
        elseif ($this->collaboratorPosts->contains($post))
        {
            return true;
        }else
            {
            return false;
        }
    }




}
