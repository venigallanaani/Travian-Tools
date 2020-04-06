<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

use Carbon\Carbon;

use App\Servers;
use App\MapData;
use App\Diff;
use App\Players;
use App\Alliances;
use App\Map;
use App\Plus;

class CleanUpPlus extends Command
{

    protected $signature = 'process:PlusCleanUp';

    protected $description = 'cleans up the tables related to Plus groups';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
       //fetch Plus groups
       
        $groups = Subscriptions::where('status','ACTIVE')->get();
    }
}
