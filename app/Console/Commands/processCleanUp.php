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


class processCleanUp extends Command
{

    protected $signature = 'process:CleanUp';

    protected $description = 'Cleans up all the old data in diff, player and alliance tables';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $servers=Servers::where('status','=','ACTIVE')->get();
        
        echo "\n".'*****************************************************************************************************'."\n";
        echo '************                            DATA CLEANUP PROCESS                              ***********'."\n";
        echo '*****************************************************************************************************'."\n";
        foreach($servers as $server){
            echo "\n".'***********************Server: '.$server->url.'***************************'."\n";
            echo "New clean up process job started at ".Carbon::now()."\n";
            
            Alliances::where('table_id','<>',$server->table_id)
                        ->where('server_id',$server->server_id)->delete();
            echo "Allainces table cleanup completed"."\n";

            Players::where('table_id','<>',$server->table_id)
                        ->where('server_id',$server->server_id)->delete();
            echo "Players table cleanup completed"."\n";

            Diff::where('table_id','<>',$server->table_id)
                        ->where('server_id',$server->server_id)->delete();
            echo "Diff table cleanup completed"."\n";
            
            $maps = Map::where('server_id',$server->server_id)
                        ->where('status','ACTIVE')->orderBy('created_at','desc')->get();
            if(count($maps)>10){
                for($i=10;$i<count($maps);$i++){
                    
                    Map::where('server_id',$server->server_id)
                                ->where('map_id',$maps[$i]->map_id)
                                ->update(['status'=>'ARCHIVE']);
                    
                    MapData::where('table_id','=',$maps[$i]->map_id)->delete();
                    
                }                
            }  
            echo "Maps table cleanup completed"."\n";
            
            echo "\n".'**************************************************************************'."\n";
        }
    }
}
