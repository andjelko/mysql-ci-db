<?php

namespace Tests\Console\Commands;

use Tests\TestCase;

class SyncExternalPostCommandTest extends TestCase
{
    /** @test */
    public function test_rss_entries_are_stored_in_the_database()
    {
        $this
            ->artisan('sync:external https://stitcher.io/feed')
            ->assertExitCode(0);
    }
}
