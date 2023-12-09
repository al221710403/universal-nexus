<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Relation::enforceMorphMap([
        //     'post' => 'App\Models\Publish\Post',
        //     'task' => 'App\Models\ToDo\Task'
        // ]);
        // Relation::morphMap([
        //     'post' => App\Models\Publish\Post::class,
        //     'video' => App\Models\ToDo\Task::class,
        // ]);
    }
}
