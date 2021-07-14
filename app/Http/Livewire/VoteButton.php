<?php

namespace App\Http\Livewire;

use App\Models\BlogPost;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;
use Ramsey\Uuid\Uuid;

class VoteButton extends Component
{
    public BlogPost $post;

    public bool $isLiked = false;

    public function mount()
    {
        $this->isLiked = $this->post->isLikedBy(request()->cookie('liker_id'));
    }

    public function render()
    {
        return view('livewire.vote-button');
    }

    public function like()
    {
        if (! $likerUuid = request()->cookie('liker_id')) {
            $likerUuid = Uuid::uuid4();

            Cookie::queue('liker_id', $likerUuid, 60 * 365 * 10);
        }

        if ($this->post->isLikedBy($likerUuid)) {
            return;
        }

        $this->post->addLikeBy($likerUuid);
        $this->isLiked = true;
    }
}
