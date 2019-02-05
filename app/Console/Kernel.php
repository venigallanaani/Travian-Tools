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
			//->everyminute()
            ->daily()
            ->appendOutputTo(storage_path('logs/processLoads.log')); 
        
        // Loads all th commands from the map.sql files of all the active servers.
        $schedule->command('Load:Diff')
			//->everyminute()
            ->dailyAt('00:15')
            ->appendOutputTo(storage_path('logs/processLoads.log')); 
        
        // Loads all th commands from the map.sql files of all the active servers.
        $schedule->command('Process:Players')
			//->everyminute()
            ->dailyAt('00:30')
            ->appendOutputTo(storage_path('logs/processLoads.log'));   
        
        // Loads all th commands from the map.sql files of all the active servers.
        $schedule->command('Process:Alliances')
			//->everyminute()
            ->dailyAt('00:45')
            ->appendOutputTo(storage_path('logs/processLoads.log'));   
        
        // Loads all th commands from the map.sql files of all the active servers.
        $schedule->command('process:CleanUp')
			//->everyminute()
            ->dailyAt('01:00')
            ->appendOutputTo(storage_path('logs/processLoads.log')); 
    }
    
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
    
}
