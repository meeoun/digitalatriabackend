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
        'laravel_through_key'
    ];


    public function toArray()
    {
        $attributes = $this->attributesToArray();
        $attributes = array_merge($attributes, $this->relationsToArray());
        unset($attributes['pivot']['created_at']);
        unset($attributes['pivot']['imageable_id']);
        unset($attributes['pivot']['image_id']);
        unset($attributes['pivot']['imageable_type']);
        unset($attributes['pivot']['updated_at']);
        return $attributes;
    }

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'imageable')->withTimestamps();
    }


    public function users()
    {
        return $this->morphedByMany(User::class, 'imageable')->withTimestamps();
    }

}
