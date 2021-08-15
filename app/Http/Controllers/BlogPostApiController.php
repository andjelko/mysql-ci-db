<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogPostResource;
use App\Models\BlogPost;

class BlogPostApiController
{
    public function index()
    {
        return BlogPostResource::collection(BlogPost::all());
    }

    public function show(BlogPost $post)
    {
        return BlogPostResource::make($post)->resolve();
    }
}
