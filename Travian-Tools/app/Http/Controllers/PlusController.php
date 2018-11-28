<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlusController extends Controller
{
    //Displays the Plus Home page
    public function index(){

    	session(['title'=>'Plus']);
    	return view('Plus.General.overview');

    }

    public function show($task,$id=null){

    	session(['title'=>'Plus']);
        
        if($task=='member'){
            if($id!=null){
                return view('Plus.General.member');                     // Displays the contact details of the selected member
            }else{
                return view('Plus.General.memberDetails');              //Displays the member details
            }    		
    	}elseif($task=='incoming'){
    		return view('Plus.General.enterIncoming');          //Displays the incoming tasks
    	}elseif($task=='defense'){
            if($id!=null){
                return view('Plus.General.defenseTask');       //Displays the selected task
            }else{
                return view('Plus.General.defenseTaskList');       //Displays the defense tasks list
            }    		 
    	}elseif($task=='offense'){
            if($id!=null){
                return view('Plus.General.offenseTask');       // Displays the selected offense plan
            }else{
                return view('Plus.General.offenseTaskList');       // Displays the offense tasks List
            }    		
    	}elseif($task=='resource'){
            if($id!=null){
                return view('Plus.General.resourceTask');      // Displays the selected resource tasks
            }else{
                return view('Plus.General.resourceTaskList');      // Displays the resource tasks List
            }    		
    	}else{
    		return view('Plus.General.overview');               // Diplays the Plus Meny Overview
    	}
    }

    public function leader($task=null){

        session(['title'=>'Leader']);

        if($task == 'access'){
            return view('Plus.Leader.access');              // displays the leadership access page to edit and/or add players to group
        }elseif($task == 'subscription'){
            return view('Plus.Leader.subscription');        // displays the leadership page to extend, terminate, terminate the subscription 
        }else{
            return view('Plus.overview');
        }

    }

    public function resource($task=null){

        session(['title'=>'Resources']);

        if($task!=null){
            return view('Plus.Resources.task');              // displays the selected resource tasks details
        }else{
            return view('Plus.Resources.overview');          // Displays the resource tasks and status
        }
        
    }


}

