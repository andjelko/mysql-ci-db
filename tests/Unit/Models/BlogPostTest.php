<?php

use App\Exceptions\BlogPostCouldNotBePublished;
use App\Models\BlogPost;
use function Spatie\PestPluginTestTime\testTime;

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
    testTime()->freeze();

    $publishedBlogPost = BlogPost::factory()->published()->create(['date' => now()]);
    $draftBlogPost = BlogPost::factory()->draft()->create(['date' => now()]);

    testTime()->subSecond();
    $publishedBlogPosts = BlogPost::wherePublished()->get();
    expect($publishedBlogPosts)->toHaveCount(0);

    testTime()->addSecond();
    $publishedBlogPosts = BlogPost::wherePublished()->get();
    expect($publishedBlogPosts)->toHaveCount(1)
        ->and($publishedBlogPosts[0]->id)->toEqual($publishedBlogPost->id);
});

it('does not allow to publish a post that is already published', function () {
    $post = BlogPost::factory()->published()->create();

    $post->publish();
})->throws(BlogPostCouldNotBePublished::class);
