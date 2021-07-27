<?php

use App\Console\Commands\SyncExternalPostsCommand;
use App\Models\ExternalPost;
use Tests\Fakes\RssRepositoryFake;

it('can sync external feeds', function() {
    RssRepositoryFake::setUp();

    $urls = [
        'https://test-a.com',
        'https://test-b.com',
        'https://test-c.com',
    ];

    config()->set('services.external_feeds', $urls);

    $this->artisan(SyncExternalPostsCommand::class);

    $this->assertEquals($urls, RssRepositoryFake::getUrls());

    expect(ExternalPost::count())->toBe(3);
});
