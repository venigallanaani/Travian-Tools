<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

use Carbon\Carbon;

use App\Servers;
use App\Map;
use App\MapData;
use App\Diff;

class LoadDiff extends Command
{
    protected $signature = 'Load:Diff';
    
    protected $description = 'Processes maps_details table and loads into diff table';
    
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $servers=Servers::where('status','=','ACTIVE')->get();        
        echo "\n".'*************************************CALCULATE DIFF PROCESS******************************************'."\n";
        foreach($servers as $server){
            echo "\n".'***********************Server: '.$server->url.'***************************'."\n";
            echo "New load Diff table job started at ".Carbon::now()."\n";
                       
            echo "fetching latest data from maps_details table-".$server->table_id."\n";
            
            $villages = MapData::where('table_id','=',$server->table_id)
                            ->where('uid','<>',1)
                            ->orderBy('vid','asc')->get();
                        
            echo "Updating the diff table with latest maps data"."\n";
            
            foreach($villages as $village){ 
          
                $diff=Diff::firstOrCreate(
					['server_id'=>$village->server_id,
					    'worldid'=>$village->worldid,
                        'x'=>$village->x,
                        'y'=>$village->y,
                        'id'=>$village->id,
                        'vid'=>$village->vid,
                        'uid'=>$village->uid,
                        'player'=>$village->player],
					[	'table_id'=>$server->table_id,
						'village'=>$village->village,
						'aid'=>$village->aid,
						'alliance'=>$village->alliance,
						'population'=>$village->population
                    ]);
                                
                $sqlStr = "update diff_details set pop7=pop6, pop6=pop5, pop5=pop4, pop4=pop3, 
                                                pop3=pop2, pop2=pop1,  
                                                table_id='".$server->table_id.
                                                "',village='".$village->village.
                                                "',aid=".$village->aid.
                                                ",alliance='".$village->alliance.
                                                "',population=".$village->population. 
                                                ", pop1=population".
                                " where vid=".$diff->vid." and server_id='".$server->server_id."'";                
                DB::update(DB::raw($sqlStr)); 
            }
            echo "Updated the pop changes for last one week"."\n";
			
			$sqlStr="update diff_details set diffPop=population-pop7 where table_id='".$server->table_id."'";            
            DB::update(DB::raw($sqlStr));
            
            echo "load Diff table job completed at ".Carbon::now()."\n";            
        }
        echo "\n".'*********************************************************************************************************'."\n";
    }
}
