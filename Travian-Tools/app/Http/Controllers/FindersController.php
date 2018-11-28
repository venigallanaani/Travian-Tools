<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class FindersController extends Controller
{
    // this process will display the Finders page

    public function index(){

    	session(['title'=>'Finders']);
    	return view('finders.overview');

    }


    public function show($id){    	

    	session(['title'=>'Finders']);

    	if($id=='player'){
    		return view('finders.playerFinder');          //Displays the player finder
    	}elseif($id=='alliance'){
    		return view('finders.allianceFinder');        //Displays the alliance finder
    	}elseif($id=='natar'){
    		return view('finders.natarFinder');           //Displays the natar finder
    	}elseif($id=='inactive'){
    		return view('finders.inactiveFinder');        //Displays the inactive finder 
    	}elseif($id=='neighbour'){
    		return view('finders.neighbourFinder');       // Displays the neighbour finder
    	}else{
    		return view('finders.overview');
    	}		
    }   
    
    public function player($name=null,$id=null){
        // displays the Player finder
        if($id==null && $name==null){
            return view('finders.playerFinder');
        }else{
            return view('finders.playerFinder');
        }        
    }
    
    public function processPlayerForm(){
        // converts the player finder post into get call
        $name  = Input::get('plrNm') ;
        return Redirect::to('/finder/player/'.$name) ;
    }
    
    public function alliance($name=null,$id=null){
        //Displays the alliance finder
        if($id==null && $name==null){
            return view('finders.allianceFinder');
        }else{
            return view('finders.allianceFinder');
        }
    }
    
    public function processAllianceForm(){
        // converts the alliance finder post call into get
        $name  = Input::get('allyNm') ;
        return Redirect::to('/finder/alliance/'.$name) ;
    }
    
    public function natar(){ 
        //Displays the natar finder
        return view('finders.natarFinder');
            
    }
    
    public function inactive(){
        //Displays the inactive finder
        return view('finders.inactiveFinder');

    }
    
    public function neighbour(){        
        //Displays the neighbour finder
        return view('finders.neighbourFinder');

    }
}
