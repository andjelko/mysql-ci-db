<?php

use App\Models\BlogPost;

it('adds a slug when a blog post is created', function() {
    $blogPost = BlogPost::factory()->create([
        'title' => 'My blogpost'
    ]);

    expect($blogPost->slug)->toEqual('my-blogpost');
});

it('can determine if a blogpost is published', function() {
   $publishedBlogPost = BlogPost::factory()->published()->create();
   expect($publishedBlogPost->isPublished())->toBeTrue();

    $draftBlogPost = BlogPost::factory()->draft()->create();
    expect($draftBlogPost->isPublished())->toBeFalse();
});

it('has a scope to retrieve all published blogposts', function() {
    $publishedBlogPost = BlogPost::factory()->published()->create();
    $draftBlogPost = BlogPost::factory()->draft()->create();

    $publishedBlogPosts = BlogPost::wherePublished()->get();

    expect($publishedBlogPosts)->toHaveCount(1);
    expect($publishedBlogPosts[0]->id)->toEqual($publishedBlogPost->id);
});
