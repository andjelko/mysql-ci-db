<?php

use App\Http\Controllers\BlogPostAdminController;
use App\Http\Controllers\DeletePostController;
use App\Http\Controllers\UpdatePostSlugController;
use App\Models\BlogPost;
use App\Models\User;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

it('will allow admin users to manage blog posts', function () {
    $post = BlogPost::factory()->create();

    $admin = User::factory()->admin()->create();

    login($admin);

    get(action([BlogPostAdminController::class, 'index']))->assertSuccessful();
    get(action([BlogPostAdminController::class, 'create']))->assertSuccessful();
    post(action([BlogPostAdminController::class, 'store']))->assertRedirect();
    get(action([BlogPostAdminController::class, 'edit'], $post->slug))->assertSuccessful();
    post(action([BlogPostAdminController::class, 'update'], $post->slug))->assertRedirect();
    post(action([BlogPostAdminController::class, 'publish'], $post->slug))->assertRedirect();
    post(action(UpdatePostSlugController::class, $post->slug))->assertRedirect();
    post(action(DeletePostController::class, $post->slug))->assertRedirect();
});

it('will not allow guest users to manage blog posts', function () {
    $post = BlogPost::factory()->create();

    $guest = User::factory()->guest()->create();

    login($guest);

    get(action([BlogPostAdminController::class, 'index']))->assertForbidden();
    get(action([BlogPostAdminController::class, 'create']))->assertForbidden();
    post(action([BlogPostAdminController::class, 'store']))->assertForbidden();
    get(action([BlogPostAdminController::class, 'edit'], $post->slug))->assertForbidden();
    post(action([BlogPostAdminController::class, 'update'], $post->slug))->assertForbidden();
    post(action([BlogPostAdminController::class, 'publish'], $post->slug))->assertForbidden();
    post(action(UpdatePostSlugController::class, $post->slug))->assertForbidden();
    post(action(DeletePostController::class, $post->slug))->assertForbidden();
});



