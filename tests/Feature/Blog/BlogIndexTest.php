<?php

namespace Tests\Feature\Blog;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogIndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_shows_a_list_of_blog_posts()
    {
        $this->withoutExceptionHandling();

        BlogPost::factory()
            ->count(3)
            ->published()
            ->sequence(
                ['title' => 'Parallel php', 'date' => '2021-01-01'],
                ['title' => 'Fibers', 'date' => '2021-01-01'],
                ['title' => 'Thoughts on event sourcing', 'date' => '2021-02-01']
            )
            ->create();

        BlogPost::factory()
            ->draft()
            ->create(['title' => 'Draft post', 'date' => '2021-01-01']);

        $this
            ->get('/')
            ->assertSuccessful()
            ->assertSee('Parallel php')
            ->assertSeeInOrder([
                'Thoughts on event sourcing',
                'Fibers',
            ])
            ->assertDontSee('Draft post');
    }
}
