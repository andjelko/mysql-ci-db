<?php

namespace App\Models;

use App\Http\Controllers\BlogPostController;
use App\Models\Enums\BlogPostStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class BlogPost extends Model implements Feedable
{
    use HasFactory;

    protected $casts = [
        'date' => 'datetime',
        'likes' => 'integer',
        'status' => BlogPostStatus::class,
    ];

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        self::creating(function (BlogPost $post) {
            if (! $post->slug) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    public function publish(): self
    {
        $this->update([
            'status' => BlogPostStatus::PUBLISHED(),
        ]);

        return $this;
    }

    public function isPublished(): bool
    {
        return $this->status->equals(BlogPostStatus::PUBLISHED());
    }

    public function isLikedBy(?string $likerUuid): bool
    {
        if ($likerUuid === null) {
            return false;
        }

        return BlogPostLike::query()
            ->where('liker_uuid', $likerUuid)
            ->where('blog_post_id', $this->id)
            ->exists();
    }

    public function addLikeBy(string $likerUuid): void
    {
        BlogPostLike::create([
            'blog_post_id' => $this->id,
            'liker_uuid' => $likerUuid,
        ]);

        $this->likes += 1;

        $this->save();
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->updated($this->updated_at)
            ->link(action([BlogPostController::class, 'show'], $this->slug))
            ->summary($this->title)
            ->authorName($this->author);
    }

    public static function getFeedItems()
    {
        return self::all();
    }

    public function scopeWherePublished(Builder $builder): void
    {
        $builder
            ->where('status', BlogPostStatus::PUBLISHED())
            ->whereDate('date', '<', now()->addDay());
    }
}
