<?php

namespace App\Models\Publish;

use App\Models\User;
use DateTimeInterface;
use Spatie\Tags\HasTags;
use Laravel\Scout\Searchable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Post extends Model
{
    use HasFactory;
    use HasTags;
    use Searchable;


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
        'metadata' => 'array',
    ];


    public function images()
    {
        return $this->hasMany(Image::class);
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
        return $value ? (Storage::exists($value) ? $value : 'noimg.png') : 'noimg.png';
    }


    /**
     * Scope para incluir solo publicaciones que sean tanto publicadas
     * como públicas, y cuya fecha de publicación sea anterior (o actual).
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('published', true)
                    ->where('public', true)
                    ->where('publish_date', '<=', now());
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

    public function scopeAuthorSearch($query, $id)
    {
        return $id ? $query->where('author_id', $id) : $query;
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
    public function scopeTagsSearch($query, $tags)
    {
        if (!empty($tags)) {
            return $query->whereHas('tags', function ($query) use ($tags) {
                $query->whereIn('tags.id', $tags);
            });
        } {
            return;
        }
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

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'metadata' => $this->metadata,
        ];
    }


    /**
     * Get the indexable name for the model.
     *
     * @return array
     */
    public function searchableAs(){
        return 'posts_index';
    }


    /**
     * Determine if the model should be searchable.
     *
     * @return bool
     */
    public function shouldBeSearchable()
    {
        return $this->public === true;
    }
}
