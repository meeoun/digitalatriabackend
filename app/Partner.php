<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected  $hidden =[
        'pivot',
        'laravel_through_key'
    ];
}
