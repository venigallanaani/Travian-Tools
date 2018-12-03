<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Servers;
use Carbon\Carbon;

class LoadMaps extends Command
{

    protected $signature = 'Load:Maps';

    protected $description = 'Loads map.sql file into maps_details table with table_id';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        
        $servers=Servers::where('status','=','ACTIVE')->get();
        $dateStmp=Carbon::now()->format('Ymd');
        
        foreach($servers as $server){
            $mapsUrl='http://'.$server->url.'/map.sql';
            $tableId = $server->server_id.'-'.$dateStmp;
            echo $tableId;
        }
        
    }
}
