<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

use Carbon\Carbon;

use App\Servers;
use App\MapData;
use App\Diff;
use App\Players;

class processPlayers extends Command
{
    protected $signature = 'Process:Players';

    protected $description = 'Processes Players from maps table and updates the players table ';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $servers=Servers::where('status','=','ACTIVE')->get();
        $dateStmp=Carbon::now()->format('Ymd');
        echo "\n".'*****************************************************************************************************'."\n";
        echo '************                            PROCESS PLAYERS PROCESS                           ***********'."\n";
        echo '*****************************************************************************************************'."\n";
        foreach($servers as $server){
            echo "\n".'***********************Server: '.$server->url.'***************************'."\n";
            echo "New process players job started at ".Carbon::now()."\n";
            
            $uIds=MapData::where('table_id','=',$server->table_id)
                        ->distinct('uid')->pluck('uid');
            
            foreach($uIds as $uid){
                
                $villages = Diff::where('uid',$uid)
                                ->where('table_id',$server->table_id)->get();
                
                $diffPop=0; $status=null;$num=0;
                $aid=null;$alliance=null;$pop=0;
                $player=$villages[0]['player'];
                
                foreach($villages as $village){
                    
                    $diffPop+=$village->diffPop;
                    $pop+=$village->population;
                    $aid=$village->aid;
                    $alliance=$village->alliance;                    
                    $num+=1;
                    
                    if($village->id==1){ $tribe = 'Roman';}
                    elseif($village->id==2){ $tribe = 'Teuton';}
                    elseif($village->id==3){ $tribe = 'Gaul';}
                    elseif($village->id==4){ $tribe = 'Nature';}
                    elseif($village->id==5){ $tribe = 'Natar';}
                    elseif($village->id==6){ $tribe = 'Egyptian';}
                    elseif($village->id==7){ $tribe = 'Hun';}
                    else{$tribe='Natar';}
                    
                }
                if($diffPop == 0){ $status = 'Inactive'; }
                elseif($diffPop > 1){ $status = 'Active';}
                else{ $status = 'Under Attack';}              
                
                Players::updateOrCreate([
                   'server_id'=>$server->server_id,
                    'uid'=>$uid,
                    'player'=>$player,
                    'tribe'=>$tribe,
                    'villages'=>$num,
                    'population'=>$pop,
                    'diffpop'=>$diffPop,
                    'aid'=>$aid,
                    'alliance'=>$alliance,
                    'table_id'=>$server->table_id
                ]);
                
                Diff::where('uid',$uid)
                        ->where('table_id',$server->table_id)
                        ->update(['status'=>$status]);
            } 
            echo 'Updated the players table and diff table'."\n";
            
            $players=MapData::where('table_id','=',$server->table_id)
                        ->pluck('uid')
                        ->orderBy('population','desc');
            
            $i=1;
            foreach($players as $player){
                Players::where('uid',$player)
                    ->where('table_id',$server->table_id)
                    ->update(['rank'=>$i]);
                $i++;
            }  
            echo 'Updated the players ranks'."\n";
        }
        echo "\n".'****************************************************************************************************'."\n";
    }
}
