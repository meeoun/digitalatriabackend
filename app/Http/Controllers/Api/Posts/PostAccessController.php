<?php

namespace App\Http\Controllers\Api\Posts;

use App\Http\Controllers\Api\ApiController;
use App\Post;

class PostAccessController extends ApiController
{
    public function index(Post $post)
    {
        $author = $post->owner;
        $collabs = $post->collaborators;
        $partners = $post->partners;
        $collabs->push($author);

        foreach($partners as $partner)
        {
            $collabs->push($partner);
        }
        return $this->showAll($collabs);
    }
}
