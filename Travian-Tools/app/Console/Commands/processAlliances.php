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

class processAlliances extends Command
{

    protected $signature = 'Process:Alliances';

    protected $description = 'Processes Alliances from maps table and updates the alliance table';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $servers=Servers::where('status','=','ACTIVE')->get();

        echo "\n".'*****************************************************************************************************'."\n";
        echo '************                            PROCESS ALLIANCES PROCESS                           ***********'."\n";
        echo '*****************************************************************************************************'."\n";
        foreach($servers as $server){
            echo "\n".'***********************Server: '.$server->url.'***************************'."\n";
            echo "New process alliance job started at ".Carbon::now()."\n";
            
            $aIds=MapData::where('table_id','=',$server->table_id)
                    ->where('aid','<>',0)
                    ->orderBy('aid','asc')
                    ->distinct('aid')->pluck('aid');
            
            foreach($aIds as $aid){
                
                $players=Players::where('aid',$aid)
                            ->where('table_id',$server->table_id)->get();
                
                $population=0; $diffPop=0; $villages=0;
                
                foreach($players as $player){
                    $population+=$player->population;
                    $diffPop+=$player->diffpop;
                    $villages+=$player->villages;
                    $alliance=$player->alliance;
                }
                                
                Alliances::updateOrCreate([
                    'server_id'=>$server->server_id,
                    'aid'=>$aid,
                    'alliance'=>$alliance,
                    'players'=>count($players),
                    'villages'=>$villages,
                    'population'=>$population,
                    'diffpop'=>$diffPop,
                    'table_id'=>$server->table_id
                ]);                
            }
            echo 'Updated the Alliance table'."\n";
            
            $alliances=Alliances::where('table_id','=',$server->table_id)
                            ->orderBy('population','desc')
                            ->pluck('aid');            
                            
            $i=1;
            foreach($alliances as $aid){
                Alliances::where('aid',$aid)
                    ->where('table_id',$server->table_id)
                    ->update(['rank'=>$i]);
                $i++;
            }
            echo 'Updated the Alliance ranks'."\n";            
        }
        echo "\n".'****************************************************************************************************'."\n";
    }
}
