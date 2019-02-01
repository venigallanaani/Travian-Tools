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
            ->dailyAt('00:00')
            ->appendOutputTo(storage_path('logs/processLoads.log')); 
        
        // Loads all th commands from the map.sql files of all the active servers.
        $schedule->command('Load:Diff')
            ->dailyAt('00:15')
            ->appendOutputTo(storage_path('logs/processLoads.log')); 
        
        // Loads all th commands from the map.sql files of all the active servers.
        $schedule->command('Process:Players')
            ->dailyAt('00:30')
            ->appendOutputTo(storage_path('logs/processLoads.log'));   
        
        // Loads all th commands from the map.sql files of all the active servers.
        $schedule->command('Process:Alliances')
            ->dailyAt('00:45')
            ->appendOutputTo(storage_path('logs/processLoads.log'));   
        
        // Loads all th commands from the map.sql files of all the active servers.
        $schedule->command('process:CleanUp')
            ->dailyAt('01:00')
            ->appendOutputTo(storage_path('logs/processLoads.log')); 
    }
    
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
    
}
