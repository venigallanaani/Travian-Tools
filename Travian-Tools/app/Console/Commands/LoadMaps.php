<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

use App\Servers;
use App\Map;
//use App\MapData;

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
            echo "\n".'**************************************************************'."\n";
            echo "New load servers job started at ".Carbon::now()."\n";
            echo "Server: ".$server->url."\n";
            
            
            $mapsUrl='https://'.$server->url.'/map.sql';
            $tableId = $server->server_id.'_'.$dateStmp;             
            $contents=file_get_contents($mapsUrl);
            
            $file='App/Downloads/'.$tableId;
            file_put_contents($file, $contents);
            echo 'file name '.$file.' is downloaded successfully'."\n";
            
            if($server->table_id==$tableId){
                echo 'Maps already loaded for today, going to refresh'."\n"; 
                
            }else{
                echo 'Processsing Map.sql data'."\n";
                
                //$Map::create([''])
                
                $server::where('server_id',$server->server_id)
                    ->update(['days'=>$server->days+1]);
                $server::where('server_id',$server->server_id)
                    ->update(['table_id'=>$tableId]);
                
            }
            
            $fileData = fopen($file,"r") or die("Unable to open file");
            
            $mapsArray=array(); $village=array();
            
            while(!feof($fileData)){
                //fetch data of the current line
                $line=fgets($fileData);
                $line = $line.substring($line.indexOf("(")+1);
                $line = $line.substring(0,$line.indexOf(")"));
                
                echo $currLine."\n";
                //$village = explode(" ", $currLine);
                
                //$sqlStr=str_replace("`x_world` VALUES (", "`".$server->maps_table."` VALUES ('".$server->server_id."',", $currLine);
                //$sqlStr=str_replace(");",",'".$tableId."',CURRENT_TIMESTAMP);" , $sqlStr);
                
                //$mapsSqlStr.=$sqlStr;
            }
            fclose($fileData); 
            
            //echo $mapsSqlStr;
            
            echo "\n".'**************************************************************'."\n";
        }
        
    }
}
