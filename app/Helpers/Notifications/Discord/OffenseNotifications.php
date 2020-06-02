<?php
use App\Discord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

if(!function_exists('DiscordOPSNotification')){

    function DiscordOPSNotification($discord, $server, $plus){
        
        $webhook = Discord::select('off_link')->where('server_id',$server)
                        ->where('plus_id',$plus)->first();
        
        if($webhook!=null && $webhook->off_link!=null){
            $fields[] = array('name'=>'Created By', 'value'=>$discord['create']);
            $fields[] = array('name'=>'Updated By', 'value'=>$discord['update']);
            
            if($discord['status']=='PUBLISH'){
                $content = "@everyone - New Offense Plan Published";
            }else if($discord['status']=='COMPLETE'){
                $content = "Offense Plan Changed to Complete";
            }else if($discord['status']=='DELETE'){
                $content = "Offense Plan Deleted";
            }else{
                $conent = "Offense Plan Update";
            }
            
            $description = '**Plan - ['.$discord['plan'].']('.$discord['link'].')**';
            
            $data = array(
                "username"=>"Travian-Tools" ,
                "avatar_url"=> "https://i.imgur.com/HX89XGr.png",
                "content"=> $content,
                "embeds"=> array(
                    array(
                        "description"=>$description,
                        "color"=> 14030126,
                        "fields"=>$fields
                    )
                )
            );                  
            sendDiscordNotification($data,$webhook->off_link);
        }
    }    
}

if(!function_exists('DiscordOpsWaveNotification')){
    
    function DiscordOpsWaveNotification($discord, $server, $plus){
        
        $webhook = Discord::select('ldr_off_link')->where('server_id',$server)
                        ->where('plus_id',$plus)->first();
        
        if($webhook!=null && $webhook->ldr_off_link!=null){
            
            $content = '**[Offense Plan Update]('.$discord['plan_link'].')** - '.
                        '['.$discord['attack'].']('.$discord['a_link'].') -> '.
                        $discord['waves'].' '.$discord['type'].' waves -> '.
                        '['.$discord['target'].']('.$discord['t_link'].') '.
                        '**'.$discord['status'].'ed**';
            
            $data = array(
                "username"=>"Travian-Tools" ,
                "avatar_url"=> "https://i.imgur.com/HX89XGr.png",
                "content"=> $content
            );
            sendDiscordNotification($data,$webhook->ldr_off_link);
        }
    }
}

?>

