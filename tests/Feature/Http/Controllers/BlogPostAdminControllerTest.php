<?php

use App\Http\Controllers\BlogPostAdminController;
use App\Models\BlogPost;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

it('will update a blog post when an admin is logged in', function () {
    $post = BlogPost::factory()->create();

    $sendRequest = fn() => post(action([BlogPostAdminController::class, 'update'], $post->slug), [
        'title' => 'test',
        'author' => $post->author,
        'body' => $post->body,
        'date' => $post->date->format('Y-m-d'),
    ]);

    $sendRequest()->assertRedirect(route('login'));

    login();

    $sendRequest();

    expect($post->refresh()->title)->toBe('test');
});
