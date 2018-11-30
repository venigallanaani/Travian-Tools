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
        //$schedule->call(new LoadServers)->hourlyAt(5);  //loads the map.sql file into table for all the partners in Servers table into Maps table
        
        $schedule->command('command:LoadMaps')->everyFiveMinutes();
        
    }
    
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
    
}
