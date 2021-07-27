<?php

use App\Http\Controllers\BlogPostAdminController;
use App\Models\BlogPost;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

beforeEach(function() {
    $this->post = BlogPost::factory()->create();
});

it('will update a blog post when an admin is logged in', function () {
    $sendRequest = fn() => post(action([BlogPostAdminController::class, 'update'], $this->post->slug), [
        'title' => 'test',
        'author' => $this->post->author,
        'body' => $this->post->body,
        'date' => $this->post->date->format('Y-m-d'),
    ]);

    $sendRequest()->assertRedirect(route('login'));

    login();

    $sendRequest();

    expect($this->post->refresh()->title)->toBe('test');
});

it('validates required fields on the post edit form', function () {
    login();

    post(action([BlogPostAdminController::class, 'update'], $this->post->slug), [])
        ->assertSessionHasErrors(['title', 'author', 'body', 'date']);

    post(action([BlogPostAdminController::class, 'update'], $this->post->slug), [
        'title' => 'test',
        'author' => $this->post->author,
        'body' => $this->post->body,
        'date' => $this->post->date->format('Y-m-d'),
    ])->assertSessionHasNoErrors();
});

it('will validate the date format on the post edit form', function() {
    login();

    post(action([BlogPostAdminController::class, 'update'], $this->post->slug), [
        'title' => $this->post->title,
        'author' => $this->post->author,
        'body' => $this->post->body,
        'date' => '01/01/2021',
    ])->assertSessionHasErrors([
        'date' => 'The date does not match the format Y-m-d.'
    ]);
});
