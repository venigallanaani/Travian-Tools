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

        echo "\n".'*****************************************************************************************************'."\n";
        echo '************                            PROCESS PLAYERS PROCESS                           ***********'."\n";
        echo '*****************************************************************************************************'."\n";
        foreach($servers as $server){
            echo "\n".'***********************Server: '.$server->url.'***************************'."\n";
            echo "New process players job started at ".Carbon::now()."\n";
            
            $uIds=MapData::where('table_id','=',$server->table_id)
                        ->where('uid','<>',1)
                        ->orderBy('uid','asc')
                        ->distinct('uid')->pluck('uid');
            
            foreach($uIds as $uid){
                
                $details = DB::table('diff_details')
                            ->select('player','id','aid','alliance','village','population', 'diffpop')
                            ->where('uid', '=', $uid)
                            ->where('table_id', '=', $server->table_id)->get();              
                
                $population = 0; $diffPop = 0;
                
                foreach($details as $detail){
                    
                    $population+=$detail->population;
                    $diffPop+=$detail->diffpop;
                    
                }
                    if($details[0]->id==1){ $tribe = 'Roman';}
                    elseif($details[0]->id==2){ $tribe = 'Teuton';}
                    elseif($details[0]->id==3){ $tribe = 'Gaul';}
                    elseif($details[0]->id==4){ $tribe = 'Nature';}
                    elseif($details[0]->id==5){ $tribe = 'Natar';}
                    elseif($details[0]->id==6){ $tribe = 'Egyptian';}
                    elseif($details[0]->id==7){ $tribe = 'Hun';}
                    else{$tribe='Natar';}   
                    
                    Players::updateOrCreate([
                        'server_id'=>$server->server_id,
                        'uid'=>$uid,
                        'player'=>$details[0]->player,
                        'tribe'=>$tribe,
                        'villages'=>count($details),
                        'population'=>$population,
                        'diffpop'=>$diffPop,
                        'aid'=>$details[0]->aid,
                        'alliance'=>$details[0]->alliance,
                        'table_id'=>$server->table_id
                    ]);
                    
                    if($diffPop == 0){ $status = 'Inactive'; }
                    elseif($diffPop > 1){ $status = 'Active';}
                    else{ $status = 'Under Attack';}
                    
                    Diff::where('uid',$uid)
                        ->where('table_id',$server->table_id)
                        ->update(['status'=>$status]);

            } 
            echo 'Updated the players table and diff table'."\n";
            
            $players=Players::where('table_id','=',$server->table_id)                        
                        ->orderBy('population','desc')
                        ->pluck('uid');
            
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
