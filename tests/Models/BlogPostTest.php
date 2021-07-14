<?php

namespace Tests\Models;

use App\Models\BlogPost;
use App\Models\Enums\BlogPostStatus;
use Carbon\Carbon;
use Tests\TestCase;

class BlogPostTest extends TestCase
{
    /** @test */
    public function test_published_scope()
    {
        BlogPost::factory()->create([
            'date' => '2021-06-01',
            'status' => BlogPostStatus::PUBLISHED(),
        ]);

        $this->travelTo(Carbon::make('2021-01-01'));

        $this->assertEquals(0, BlogPost::query()->wherePublished()->count());

        $this->travelTo(Carbon::make('2021-06-01'));

        $this->assertEquals(1, BlogPost::query()->wherePublished()->count());
    }
}
