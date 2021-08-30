<?php

namespace App\Jobs;

use App\Models\BlogPost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Browsershot\Browsershot;

class CreateOgImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private BlogPost $post
    ) {
    }

    public function handle()
    {
        $this->post->saveOgImage(
            Browsershot::html(view('blog.ogImage', ['post' => $this->post])->render())
                ->devicePixelRatio(2)
                ->windowSize(1200, 630)
                ->screenshot()
        );
    }
}
