<?php

namespace App\Console;

use App\Models\Publish\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->call(function () {
        //     $files = Storage::files('publish/post/image');
        //     $images = Image::pluck('image_url')->toArray();
        //     Storage::delete(array_diff($files, $images));
        // })->dailyAt('1:17');

        // $schedule->call(function () {
        //     $files = Storage::files('publish/post/image');
        //     $images = Image::pluck('image_url')->toArray();
        //     Storage::delete(array_diff($files, $images));
        // })->twiceDaily(9, 13);

        $schedule->call(function () {
            $files = Storage::files('publish/post/image');
            $images = Image::pluck('image_url')->toArray();
            Storage::delete(array_diff($files, $images));
        })->twiceDaily(17, 21);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
