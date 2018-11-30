<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LoadMaps extends Command
{

    protected $signature = 'command:LoadMaps';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        echo 'Loading Maps Now';
    }
}
