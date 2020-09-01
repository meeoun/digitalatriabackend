<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collaborator extends Model
{


        public function user()
        {
            return $this->hasOne(User::class,'id','user_id');
        }


        public function post()
        {
            return $this->hasOne(Post::class,'id', 'post_id');
        }

}
