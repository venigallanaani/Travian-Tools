<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        //
    ];
    
    protected function schedule(Schedule $schedule)
    {
       // Loads all th commands from the map.sql files of all the active servers.
        $schedule->command('Load:Maps')
            ->everyMinute()
            ->appendOutputTo(storage_path('logs/loadMaps.log'));
        
    }
    
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
    
}
