<?php
use App\Discord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

if(!function_exists('DiscordCFDNotification')){
// Send out Discord notification for the Defense calls/updates/filled/withdraws
    function DiscordCFDNotification($discord, $server, $plus){
        
        $webhook = Discord::select('def_link')->where('server_id',$server)
                        ->where('plus_id',$plus)->first();         
        
        if($webhook!=null && $webhook->def_link!=null){
            $fields[] = array('name'=>'Coords',
                'value'=>'**['.$discord['x'].'|'.$discord['y'].']('.$discord['url'].')**'
            );
            if($discord['defense']!= null){
            $fields[] = array('name'=>'Defense needed',
                'value'=>number_format($discord['defense'])
            );
            }
            if($discord['time']!= null){
            $fields[] = array('name'=>'Target Time',
                'value'=>$discord['time']
            );
            }
            if($discord['type']!= null){
                $fields[] = array('name'=>'Type',
                    'value'=>ucfirst($discord['type']),
                    'inline'=>true
                );
            }
            if($discord['priority']!= null){
                $fields[] = array('name'=>'Priority',
                    'value'=>ucfirst($discord['priority']),
                    'inline'=>true
                );
            }
            if($discord['notes']!= null){
                $fields[] = array('name'=>'Notes',
                    'value'=>$discord['notes']
                );
            }
            if($discord['crop']!= null){
                if($discord['crop']==true){
                    $fields[] = array('name'=>'Send Crop',
                        'value'=>'Yes'
                    );
                }else{
                    $fields[] = array('name'=>'Send Crop',
                        'value'=>'No'
                    );
                }
            }
            
            if($discord['status']=='NEW'){
                $content = "@everyone - NEW DEFENSE CALL";
            }else if($discord['status']=='UPDATE'){
                $content = "DEFENSE CALL UPDATE";
            }else if($discord['status']=='COMPLETE'){
                $content = "DEFENSE CALL FILLED";
            }else if($discord['status']=='DELETE'){
                $content = "DEFENSE CALL REMOVED";
            }else if($discord['status']=='WITHDRAW'){
                $content = "@everyone - WITHDRAW TROOPS";
            }else{
                $conent = "DEFENSE CALL UPDATE";
            }
            
            $description = '**Target - ['.$discord['player'].' ('.$discord['village'].')]('.$discord['link'].')**';
            
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
            sendDiscordNotification($data,$webhook->def_link);
        }
    }    
}

if(!function_exists('DiscordIncomingNotification')){
// Sends out discord notification to DCs whenever new incomings are uploaded into the tool
    function DiscordIncomingNotification($discord, $server, $plus){
        
        $webhook = Discord::select('ldr_def_link')->where('server_id',$server)
                        ->where('plus_id',$plus)->first();
        
        if($webhook!=null && $webhook->ldr_def_link!=null){
            
            $fields[] = array('name'=>'Coords',
                'value'=>'**['.$discord['x'].'|'.$discord['y'].']('.$discord['url'].')**'
            );            
            $fields[] = array('name'=>'Total Waves',
                'value'=>$discord['waves']
            );            
            $fields[] = array('name'=>'Earliest Land Time',
                'value'=>$discord['time']
            );           
            

            $content = "@here - NEW INCOMING UPLOADED";
            $description = '**Defender - ['.$discord['player'].' ('.$discord['village'].')]('.$discord['link'].')**';
            
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
            sendDiscordNotification($data,$webhook->ldr_def_link);
        }
    }
}

if(!function_exists('DiscordAttackerNotification')){
// Sends out Dicord notification to DCs whenever there is a change in the attacking hero stats and gear
    function DiscordAttackerNotification($discord, $server, $plus){
        
        $webhook = Discord::select('ldr_def_link')->where('server_id',$server)
                        ->where('plus_id',$plus)->first();
        
        $fields[] = array('name'=>'Experience Change',
            'value'=>$discord['xp']
        );
    
        $fields[] = array('name'=>'Attacker Points',
            'value'=>$discord['off']
        );
    
        $fields[] = array('name'=>'Defender Points',
            'value'=>$discord['def']
        );
    
        $fields[] = array('name'=>'Equipment Change',
            'value'=>$discord['gear']
        );
        
        $content = "@here - HERO Changed noticed";
        $description = '**Attacker - ['.$discord['player'].']('.$discord['link'].')**';
        
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
        sendDiscordNotification($data,$webhook->ldr_def_link);
    }
}
?>

