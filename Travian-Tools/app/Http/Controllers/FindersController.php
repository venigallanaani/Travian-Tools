<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

use App\MapData;

class FindersController extends Controller
{
    // this process will display the Finders page

    public function index(){

    	session(['title'=>'Finders']);
    	return view('finders.overview');

    }
    
    public function processPlayer(){
        // converts the player finder post into get call
        $name  = Input::get('plrNm') ;
        return Redirect::to('/finder/player/'.$name) ;
    }
    
    public function player($name=null,$id=null){
        // displays the Player finder
        if($id==null && $name==null){
            return view('finders.Player.playerFinder');
        }elseif($id==null && $name!=null){
            
            $maps=MapData::where('player','like','%'.$name.'%')
                ->where('table_id','t6angr1_20181204')
                ->orderBy('population','desc')->get();
            
            if(count($maps)==0){
                return view('Finders.Player.noPlayers')->with('player',$name);
            }else{
                return view('finders.Player.manyPlayers');
            }           
            
        }else{
            return view('finders.Player.onePlayer');
        }  
    }   
    
    public function alliance($name=null,$id=null){
        //Displays the alliance finder
        if($id==null && $name==null){
            return view('finders.Alliance.allianceFinder');
        }elseif($id==null && $name!=null){
            return view('finders.Alliance.manyAlliances');
        }else{
            return view('finders.Alliance.oneAlliance');
        }
    }
    
    public function processAlliance(){
        // converts the alliance finder post call into get
        $name  = Input::get('allyNm') ;
        return Redirect::to('/finder/alliance/'.$name) ;
    }
    
    public function natar(){ 
        //Displays the natar finder
        return view('finders.Natar.natarFinder');            
    }
    
    public function processNatar(Request $request){
        //Displays the natar finder
        return view('finders.Natar.natarList');        
    }
    
    public function inactive(){
        //Displays the inactive finder
        return view('finders.Inactive.inactiveFinder');
    }
    
    public function processInactive(Request $request){
        //Displays the inactive finder
        return view('finders.Inactive.inactiveList');
    }
    
    public function neighbour(){        
        //Displays the neighbour finder
        return view('finders.Neighbour.neighbourFinder');
    }
    
    public function processNeighbour(Request $request){
        //Displays the neighbour finder
        return view('finders.Neighbour.neighbourslist');
    }
}
