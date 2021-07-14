<?php

namespace Tests\Http\Controllers;

use App\Http\Controllers\JsonPostController;
use App\Models\BlogPost;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class JsonPostControllerTest extends TestCase
{
    /** @test */
    public function index_shows_all_blog_posts()
    {
        BlogPost::factory()->count(2)->create();

        $this->get(action([JsonPostController::class, 'index']))
            ->assertSuccessful()
            ->assertJson(function (AssertableJson $json) {
                $json
                    ->has('data', 2)
                    ->has('data.0', function (AssertableJson $json) {
                        $json
                            ->has('id')
                            ->has('date')
                            ->has('slug')
                            ->etc();
                    })
                ;
            });
    }

    /** @test */
    public function detail_shows_one_blog_post()
    {
        [$postA, $postB] = BlogPost::factory()->count(2)->create();

        $this->get(action([JsonPostController::class, 'show'], $postA->slug))
            ->assertSuccessful()
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('id')
                    ->whereType('id', 'integer')
                    ->whereType('date', 'string')
                    ->whereAllType([
                        'id' => 'integer',
                        'date' => 'string',
                    ])
                    ->where('id', $postA->id)
                    ->etc()
            )
        ;
    }
}
