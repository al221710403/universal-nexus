<?php

namespace App\Models;

use App\Models\Publish\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    /**
     * Get all of the posts that are assigned this tag.
     */
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    public static function findFromString(string $name, string $type = null)
    {
        return static::query()
            ->where('type', $type)
            ->where(function ($query) use ($name) {
                $query->where("name", $name)
                    ->orWhere("slug", $name);
            })
            ->first();
    }
}
