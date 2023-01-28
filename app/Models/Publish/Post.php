<?php

namespace App\Models\Publish;

use App\Models\User;
use DateTimeInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    public $dates = [
        'publish_date',
    ];

    /**
     * The attributes that should be casted.
     *
     * @var array
     */
    protected $casts = [
        'meta' => 'array',
        'published' => 'boolean',
        'public' => 'boolean',
        'markdown' => 'boolean',
    ];

    /**
     * The tags the post belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'posts_tags', 'post_id', 'tag_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function tagsFilter()
    {
        return $this->hasMany(PosTag::class, 'post_id', 'id');
    }

    /**
     * The post author.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }


    public function getFeaturedImageAttribute($value)
    {
        if ($value == null) {
            return 'noimg.png';
        } else {
            if (file_exists('storage/' . $value)) {
                return $value;
            } else {
                return 'noimg.png';
            }
        }
    }


    /**
     * Scope a query to only include published posts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    /**
     * Scope a query to only include public posts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublic($query)
    {
        return $query->where('public', true);
    }

    /**
     * Scope a query to only include drafts (unpublished posts).
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDraft($query)
    {
        return $query->where('published', false);
    }

    /**
     * Scope a query to only include posts whose publish date is in the past (or now).
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLive($query)
    {
        return $query->published()->where('publish_date', '<=', now());
    }

    public function scopeStatus($query, $status = 'all')
    {
        switch ($status) {
            case 'all':
                return;
                break;
            case 'published':
                return $query->where('published', true);
                break;
            case 'draft':
                return $query->where('published', false);
                break;
        }
    }

    /**
     * Scope a query to only include posts whose publish date is in the future.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeScheduled($query)
    {
        return $query->where('publish_date', '>', now());
    }

    public function scopeAuthor($query, $id)
    {
        if ($id) {
            return $query->where('author_id', $id);
        } else {
            return;
        }
    }

    public function scopeMypost($query)
    {
        return $query->where('author_id', Auth::user()->id);
    }

    /**
     * Scope a query to only include posts whose publish date is before a given date.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBeforePublishDate($query, $date)
    {
        return $query->where('publish_date', '<=', $date);
    }

    /**
     * Scope a query to only include posts whose publish date is after a given date.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAfterPublishDate($query, $date)
    {
        return $query->where('publish_date', '>', $date);
    }

    /**
     * Scope a query to only include posts that have a specific tag (by slug).
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $slug
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTagsf($query, $slugs)
    {
        if (!empty($slugs)) {
            // return $query->whereIn('id',  $slugs);
            return $query->whereHas('tagsFilter', function ($query) use ($slugs) {
                $query->whereIn('tag_id', $slugs);
            });
        } {
            return;
        }
        // return $query->whereHas('tags', function ($query) use ($slug) {
        //     $query->where('slug', $slug);
        // });
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
