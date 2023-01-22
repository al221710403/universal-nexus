<?php

namespace App\Observers;

use App\Models\Publish\PosTag;

class PostTagObserver
{
    /**
     * Handle the PostTag "created" event.
     *
     * @param  \App\Models\PostTag  $postTag
     * @return void
     */
    public function created(PosTag $postTag)
    {
        dd($postTag);
    }

    /**
     * Handle the PostTag "updated" event.
     *
     * @param  \App\Models\PostTag  $postTag
     * @return void
     */
    public function updated(PosTag $postTag)
    {
        //
    }

    /**
     * Handle the PostTag "deleted" event.
     *
     * @param  \App\Models\PostTag  $postTag
     * @return void
     */
    public function deleted(PosTag $postTag)
    {
        //
    }

    /**
     * Handle the PostTag "restored" event.
     *
     * @param  \App\Models\PostTag  $postTag
     * @return void
     */
    public function restored(PosTag $postTag)
    {
        //
    }

    /**
     * Handle the PostTag "force deleted" event.
     *
     * @param  \App\Models\PostTag  $postTag
     * @return void
     */
    public function forceDeleted(PosTag $postTag)
    {
        //
    }
}
