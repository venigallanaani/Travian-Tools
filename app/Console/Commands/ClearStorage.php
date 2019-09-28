<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Artisan;
use Carbon\Carbon;

class ClearStorage extends Command
{

    protected $signature = 'Clear:Storage';

    protected $description = 'Clears the cache data in the storage folder';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        echo "\n".'*************************************Cleaning up cache views at '.Carbon::now().' ******************************************'."\n";
        Artisan::call('view:clear');
        
    }
}
