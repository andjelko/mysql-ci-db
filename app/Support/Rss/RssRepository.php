<?php

namespace App\Support\Rss;

use Feed;
use Illuminate\Support\Collection;

class RssRepository
{
    /**
     * @return \Illuminate\Support\Collection|\App\Support\Rss\RssEntry[]
     */
    public function fetch(string $url): Collection
    {
        return collect(Feed::load($url)->toArray()['entry'] ?? [])
            ->map(fn (array $data) => RssEntry::fromArray($data));
    }
}
