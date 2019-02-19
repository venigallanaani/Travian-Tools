<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;
use Carbon\Carbon;

use App\Servers;
use App\Map;
use App\MapData;

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
        
        echo "\n".'**********************************LOAD MAPS PROCESS***************************************'."\n";
        foreach($servers as $server){
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
            
            echo "Load servers job completed at ".Carbon::now()."\n";            
        }
        echo "\n".'*************************************************************************************************'."\n";
    }
}
