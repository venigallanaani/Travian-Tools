<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;
use Carbon\Carbon;

use App\Servers;
use App\Map;
use App\MapData;
use App\Diff;
use App\Players;
use App\Alliances;

class LoadServers extends Command
{

    protected $signature = 'Load:Servers';

    protected $description = 'Loads and processes the Maps.sql data of each active server';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get Servers Data
        $servers=Servers::where('status','ACTIVE')->get();
        $dateStmp=Carbon::now()->format('Ymd');
        
        echo "\n".'**********************************LOAD SERVERS PROCESS***************************************'."\n";
        foreach($servers as $server){
            
//            $timezone = $server->timezone;
            
//            if(1==1){                
        //Downloads and loads the maps.sql data into the maps_details table
                echo "\n".'***********************Server: '.$server->url.'***************************'."\n";
                echo "New load servers job started at ".Carbon::now()."\n";
                
                $mapsUrl='https://'.$server->url.'/map.sql';
                $tableId = $server->server_id.'_'.$dateStmp;
                $contents=file_get_contents($mapsUrl);
                
                $file=env("DOWNLOAD_LOCATION","app/Downloads/").$tableId;
                file_put_contents($file, $contents);
                echo 'file name '.$file.' is downloaded successfully'."\n";
                
                if($server->table_id==$tableId){
                    echo 'Maps already loaded for today, going to refresh'."\n";
                    
                    Map::where('map_id',$tableId)
                            ->update(['status'=>'ACTIVE']);
                    Servers::where('server_id',$server->server_id)
                            ->update(['table_id'=>$tableId]);
                    MapData::where('table_id',$tableId)->delete();
                    
                    echo 'Completed removing entries with table id '.$tableId."\n";
                }else{
                    echo 'Processsing Map.sql data'."\n";
                    
                    Map::create(['map_id'=>$tableId,'server_id'=>$server->server_id,'status'=>'ACTIVE']);
                    
                    Servers::where('server_id',$server->server_id)
                    ->update(['days'=>$server->days+1]);
                    Servers::where('server_id',$server->server_id)
                    ->update(['table_id'=>$tableId]);
                    
                }
                
                $fileData = fopen($file,"r") or die("Unable to open file");
                
                $villageSql=null;
                
                while(!feof($fileData)){
                    //fetch data of the current line
                    $line=fgets($fileData);
                    $line=trim($line);
                    
                    if(strlen($line)>0){
                        $villageSql=str_replace("`x_world` VALUES (", "`".$server->maps_table."` VALUES ('".$server->server_id."',", $line);
                        $villageSql=str_replace(");",",'".$tableId."',CURRENT_TIMESTAMP);" , $villageSql);
                        
                        DB::insert(DB::raw($villageSql));
                    }
                }            
                fclose($fileData);
                //Delete the download file
                unlink($file);            
                echo "Load servers job completed at ".Carbon::now()."\n";
                
        // Updates the diff_details table with the SQL Data
                echo "\n".'**********************************************************************'."\n";
                echo "New load Diff table job started at ".Carbon::now()."\n";            
                echo "fetching latest data from maps_details table-".$tableId."\n";
                
                MapData::where('table_id',$tableId)
                        ->where('uid','<>',1)->orderBy('vid','asc')
                        ->chunk(50,function($villages){
                            
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
                                    [	'table_id'=>$village->table_id,
                                        'village'=>$village->village,
                                        'aid'=>$village->aid,
                                        'alliance'=>$village->alliance,
                                        'population'=>$village->population
                                    ]);
                                
                                $sqlStr = "update diff_details set pop7=pop6, pop6=pop5, pop5=pop4, pop4=pop3,
                                                pop3=pop2, pop2=pop1,
                                                table_id='".$village->table_id.
                                                "',village='".$village->village.
                                                "',aid=".$village->aid.
                                                ",alliance='".$village->alliance.
                                                "',population=".$village->population.
                                                ", pop1=population".
                                                " where vid=".$diff->vid." and server_id='".$village->server_id."' and uid=".$village->uid;
                                DB::update(DB::raw($sqlStr));
                            }                        
                        });
                
                $sqlStr="update diff_details set diffPop=population-pop7 where table_id='".$tableId."'";
                DB::update(DB::raw($sqlStr));
                
                echo "load Diff table job completed at ".Carbon::now()."\n";
                
        // Updates the players details and the status
        
                
                echo "\n".'*************************************************************************'."\n";
                echo "New process players job started at ".Carbon::now()."\n";
                
                MapData::select('uid','table_id')->where('table_id',$tableId)
                        ->where('uid','<>',1)->orderBy('uid','asc')->distinct('uid')
                        ->chunk(50,function($uIds){
                            
                            foreach($uIds as $uid){
                                $details=Diff::select('server_id','player','id','aid','alliance','village','population', 'diffPop')
                                            ->where('uid', $uid->uid)->where('table_id',$uid->table_id)->orderBy('vid','asc')->get();
                                
                                $population = 0; $diffPop = 0;  $serverid=$details[0]->server_id;
                                $status = 'Inactive';   $villages = 0;
                                
                                if($details[0]->id==1)      { $tribe = 'Roman';     }
                                elseif($details[0]->id==2)  { $tribe = 'Teuton';    }
                                elseif($details[0]->id==3)  { $tribe = 'Gaul';      }
                                elseif($details[0]->id==4)  { $tribe = 'Nature';    }
                                elseif($details[0]->id==5)  { $tribe = 'Natar';     }
                                elseif($details[0]->id==6)  { $tribe = 'Egyptian';  }
                                elseif($details[0]->id==7)  { $tribe = 'Hun';       }
                                else                        { $tribe = 'Natar';     }
                                
                                foreach($details as $detail){                                
                                    $villages++;
                                    $population+=$detail->population;
                                    $diffPop+=$detail->diffPop;
                                    if($detail->diffPop > 0){    $status='Active';  }
                                    
                                }                            
                                
                                Players::updateOrCreate([
                                    'server_id'=>$serverid,
                                    'uid'=>$uid->uid,
                                    'player'=>$details[0]->player,
                                    'tribe'=>$tribe,
                                    'villages'=>$villages,
                                    'population'=>$population,
                                    'diffpop'=>$diffPop,
                                    'aid'=>$details[0]->aid,
                                    'alliance'=>$details[0]->alliance,
                                    'table_id'=>$uid->table_id
                                ]);
                                
                                if($status=='Active' && $diffPop<0){ $status='Under Attack'; }
                                
                                Diff::where('uid',$uid)->where('table_id',$uid->table_id)
                                        ->update(['status'=>$status]);
                                
                            }
                            
                        });
                
                echo 'Updated the players table and status in diff table'."\n";
                
                $players=Players::where('table_id',$tableId)
                            ->orderBy('population','desc')->pluck('uid');
                
                foreach($players as $i=>$player){
                    Players::where('uid',$player)
                            ->where('table_id',$tableId)->update(['rank'=>$i+1]);
                }
                echo 'Updated the players ranks'."\n";
                
                
        // Updates Alliance details
                echo "\n".'****************************************************************************'."\n";
                echo "New process alliance job started at ".Carbon::now()."\n";
                
                MapData::select('server_id','aid','table_id')->where('table_id',$tableId)
                        ->where('aid','<>',0)->distinct('aid')->orderBy('aid','asc')
                        ->chunk(50, function($aIds){
    
                            foreach($aIds as $aid){
                                $players=Players::where('aid',$aid->aid)
                                        ->where('table_id',$aid->table_id)->get();
                                
                                $population=0; $diffPop=0; $villages=0;
                                
                                foreach($players as $player){
                                    $population+=$player->population;
                                    $diffPop+=$player->diffpop;
                                    $villages+=$player->villages;
                                    $alliance=$player->alliance;
                                }
                                
                                Alliances::updateOrCreate([
                                    'server_id'=>$aid->server_id,
                                    'aid'=>$aid->aid,
                                    'alliance'=>$alliance,
                                    'players'=>count($players),
                                    'villages'=>$villages,
                                    'population'=>$population,
                                    'diffpop'=>$diffPop,
                                    'table_id'=>$aid->table_id
                                ]);
                            }                        
                        });
    
                echo 'Updated the Alliance table'."\n";
                
                $alliances=Alliances::where('table_id',$tableId)
                            ->orderBy('population','desc')->pluck('aid');
    
                foreach($alliances as $i=>$aid){
                    Alliances::where('aid',$aid)->where('table_id',$tableId)
                                ->update(['rank'=>$i+1]);
                }
                echo 'Updated the Alliance ranks'."\n";
                
        // tables cleanup process
        
                
                echo "\n".'**********************************************************************'."\n";
                echo "New clean up process job started at ".Carbon::now()."\n";
                
                Alliances::where('table_id','<>',$tableId)
                        ->where('server_id',$server->server_id)->delete();
                echo "Alliances table cleanup completed"."\n";
                
                Players::where('table_id','<>',$tableId)
                            ->where('server_id',$server->server_id)->delete();
                echo "Players table cleanup completed"."\n";
                
                Diff::where('table_id','<>',$tableId)
                            ->where('server_id',$server->server_id)->delete();
                echo "Diff table cleanup completed"."\n";
                
                $maps = Map::where('server_id',$server->server_id)
                            ->where('status','ACTIVE')->orderBy('created_at','desc')->get();
                if(count($maps)>10){
                    for($i=10;$i<count($maps);$i++){
                        // Updates the maps table status
                        Map::where('server_id',$server->server_id)
                                ->where('map_id',$maps[$i]->map_id)
                                ->update(['status'=>'ARCHIVE']);
                        
                        //Delete maps data
                        MapData::where('table_id','=',$maps[$i]->map_id)->delete();
                        
                    }
                }
                echo "tables cleanup completed"."\n";
//            }            
        }
        echo "\n".'*************************************************************************************************'."\n";
    }
}
