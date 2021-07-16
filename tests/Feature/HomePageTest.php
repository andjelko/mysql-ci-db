<?php

use App\Http\Controllers\ExternalPostSuggestionController;
use App\Mail\ExternalPostSuggestedMail;
use App\Models\BlogPost;
use App\Models\ExternalPost;
use function Pest\Laravel\assertDatabaseHas;
use \Illuminate\Support\Facades\Mail;

it('can render the homepage', function () {
    $this
        ->get('/')
        ->assertSee('My Blog');
});

it('will only show published blogposts', function () {
    $publishedBlogPost = BlogPost::factory()->published()->create();

    $draftBlogPost = BlogPost::factory()->draft()->create();

    $this
        ->get('/')
        ->assertSee($publishedBlogPost->title)
        ->assertDontSee($draftBlogPost->title);
});

it('can accept suggestions', function () {
    Mail::fake();

    $externalPostAttributes = [
        'title' => 'My title',
        'url' => 'https://example.com',
    ];

    $this
        ->post(action(ExternalPostSuggestionController::class), $externalPostAttributes)
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');

    assertDatabaseHas('external_posts', $externalPostAttributes);

    Mail::assertSent(function(ExternalPostSuggestedMail $mail) use ($externalPostAttributes) {
        if ( ! $mail->hasTo('admin@yourblog.com')) {
            return false;
        }

        if ($mail->title !== $externalPostAttributes['title']) {
            return false;
        }

        if ($mail->url !== $externalPostAttributes['url']) {
            return false;
        }

        return true;
    });
});

it('will not accept a suggestion with invalid input', function() {
    Mail::fake();

    $this
        ->post(action(ExternalPostSuggestionController::class), [
            'url' => 'https://example.com',
        ])
        ->assertSessionHasErrors(['title']);

    expect(ExternalPost::count())->toBe(0);

    Mail::assertNothingSent();
});
