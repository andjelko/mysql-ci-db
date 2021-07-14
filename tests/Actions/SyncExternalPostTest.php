<?php

namespace Tests\Actions;

use App\Actions\SyncExternalPost;
use App\Models\ExternalPost;
use App\Support\Rss\RssEntry;
use App\Support\Rss\RssRepository;
use Carbon\CarbonImmutable;
use Mockery\MockInterface;
use Tests\TestCase;

class SyncExternalPostTest extends TestCase
{
    /** @test */
    public function synced_posts_are_stored_in_the_database()
    {
        /** @var \App\Support\Rss\RssRepository $rss */
        $rss = $this->mock(RssRepository::class, function (MockInterface $mock) {
            $mock->shouldReceive('fetch')
                ->andReturn(collect([
                    new RssEntry(
                        url: 'https://test.com',
                        title: 'test',
                        date: CarbonImmutable::make('2021-01-01'),
                    )
                ]));
        });

        $sync = new SyncExternalPost($rss);

        $sync('https://test.com/feed');

        $this->assertDatabaseHas(ExternalPost::class, [
            'url' => 'https://test.com',
            'title' => 'test',
        ]);
    }
}
