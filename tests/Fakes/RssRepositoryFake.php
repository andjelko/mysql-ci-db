<?php

namespace Tests\Fakes;

use App\Support\Rss\RssEntry;
use App\Support\Rss\RssRepository;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;

class RssRepositoryFake extends RssRepository
{
    private static array $urls = [];

    public function fetch(string $url): Collection
    {
        self::$urls[] = $url;

        return collect([
            new RssEntry(
                url: 'https://test.com/' . Uuid::uuid4(),
                title: 'test',
                date: CarbonImmutable::make('2021-01-01'),
            ),
        ]);
    }

    public static function getUrls(): array
    {
        return self::$urls;
    }

    public static function setUp(): void
    {
        self::$urls = [];

        app()->instance(RssRepository::class, new self());
    }
}
