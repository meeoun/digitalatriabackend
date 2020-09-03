<?php

namespace App\Http\Controllers\Api\Posts;

use App\Http\Controllers\Api\ApiController;
use App\Post;

class PostAuthorController extends ApiController
{

    public function index(Post $post)
    {
        $author = $post->owner;
        return $this->showOne($author);
    }

}
