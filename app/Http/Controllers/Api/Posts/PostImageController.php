<?php

namespace App\Http\Controllers\Api\posts;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class PostImageController extends ApiController
{
    public function index(Post $post)
    {
        $images = $post->images;
        return $this->showAll($images);
    }
}
