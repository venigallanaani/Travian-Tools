<?php
use App\Discord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


if(!function_exists('sendDiscordNotification')){
    function sendDiscordNotification($data,$webhook){
        
        $curl = curl_init($webhook);
        
        $json_string = json_encode($data);
        
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json_string);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json_string))
            );
        //dd($json_string);
        
        echo curl_exec($curl);
    }
}

?>