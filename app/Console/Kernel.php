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
    {   //Loads data of the current servers and process them
        $schedule->command('Load:Servers')
            ->dailyAt('00:00')
            //->everyminute()
            ->appendOutputTo(storage_path('logs/LoadServers.log'));
        
         
        //Clears data from the storage folder    
        $schedule->command('Clear:Storage')
            ->dailyAt('23:00')
            //->everyminute()
            ->appendOutputTo(storage_path('logs/cleanUp.log')); 
    }
    
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
    
}
