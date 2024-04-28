<?php

namespace App\Console\Commands;

use Livewire\Livewire;
use Illuminate\Console\Command;
use App\Http\Livewire\ToDo\BoardShow;

class ExecuteLivewireMethod extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'livewire:execute-method';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute a Livewire method';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $test = Livewire::component('board-show', BoardShow::class);
        // dd($test);
        // Livewire::activate('board-show')->enviarNotificacion();
        Livewire::activate('board-show')->enviarNotificacion();

        $this->info('Livewire method executed successfully.');
        // return 0;
    }
}
