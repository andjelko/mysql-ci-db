<?php

use App\Actions\SyncExternalPostAction;
use App\Models\ExternalPost;
use App\Support\Rss\RssEntry;
use App\Support\Rss\RssRepository;
use Carbon\CarbonImmutable;
use function Pest\Laravel\assertDatabaseHas;

it('will sync an external feed to the database', function () {
    // arrange
    $rssRepository = mock(RssRepository::class)
        ->expect(fetch: function() {
            return collect([
               new RssEntry(
                  'https://test.com',
                   'test',
                   CarbonImmutable::make('2021-01-01'),
               )
            ]);
        });

    // act
    $syncExternalPostsAction = new SyncExternalPostAction($rssRepository);
    $syncExternalPostsAction('https://example.com/feed');

    // assert
    assertDatabaseHas(ExternalPost::class, [
       'url' => 'https://test.com',
       'title' => 'test',
    ]);
});
