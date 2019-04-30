<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

use App\Subscription;


class processRankings extends Command
{
    protected $signature = 'process:rankings';    
    protected $description = 'process rankings of each plus group';
    
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        
        $subscriptions = Subscription::where('status','ACTIVE')->get();
        
        echo "\n".'*************************************PROCESS PLUS PLAYER RANKINGS******************************************'."\n";
        foreach($subscriptions as $subsription){
            
            
            
            
            
            
            
        }
        
    }
}
