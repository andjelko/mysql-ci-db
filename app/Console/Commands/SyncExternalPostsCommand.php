<?php

namespace App\Console\Commands;

use App\Actions\SyncExternalPostAction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Fork\Fork;

class SyncExternalPostsCommand extends Command
{
    protected $signature = 'sync:externals';

    protected $description = 'Sync external RSS feeds';

    public function handle(SyncExternalPostAction $sync)
    {
        $feeds = config('services.external_feeds');

        $this->info('Fetching ' . count($feeds) . ' feeds');

        foreach($feeds as $feed) {
            $sync($feed);
        }

        $this->info('Done');
    }

}
