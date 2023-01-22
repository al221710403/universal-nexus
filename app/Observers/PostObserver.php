<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\Publish\Post;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function created(Post $post)
    {
        if (strlen($post->title) > 0) {
            $post->slug = Str::slug($post->title);
        } else {
            $post->slug = "new-post-" . $post->id;
        }
        $post->save();
    }

    /**
     * Handle the Post "updated" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function updated(Post $post)
    {
        // lo-ma
        // lo-ma-1 otro
        if (strlen($post->title) > 0) {
            $post->slug = $this->createSlug($post);
            $post->save();
        }
    }

    public function createSlug($post)
    {
        $slug = Str::slug($post->title);
        $slugExist = Post::where('slug', $slug)->where('id', '!=', $post->id)->first();

        if ($slugExist) {
            // $max = Post::where('title', $post->title)->count();
            // $max = $max == 0 ? 1 : $max + 1;
            return $slug . '-' . $post->id;
        } else {
            return $slug;
        }
    }

    /**
     * Handle the Post "deleted" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function deleted(Post $post)
    {
        //
    }

    /**
     * Handle the Post "restored" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function restored(Post $post)
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        //
    }
}
