<?php

namespace App\Http\Controllers\Finders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;

use App\Diff;
use App\Players;
use App\Alliances;
use App\MapData;

class PlayerFinderController extends Controller
{
    
    public function processPlayer(){
        session(['title'=>'Finders']);
        // converts the player finder post into get call
        $name  = Input::get('plrNm') ;
        return Redirect::to('/finders/player/'.$name) ;
    }
    
    public function player($name=null,$id=null, Request $request){
        session(['title'=>'Finders']);
        // displays the Player finder
        if($id==null && $name==null){
            // displays player finder form
            return view('Finders.Player.playerFinder');
        }else{            
            if($id==null){
                $players=Players::where('player','like','%'.$name.'%')
                    ->where('server_id',$request->session()->get('server.id'))
                    ->orderBy('rank','asc')->paginate(20);
            }else{
                $players=Players::where('player','=',$name)
                    ->where('server_id',$request->session()->get('server.id'))->get();
            }
            
            if(count($players)==0){
                // no players are found in search results
                return view('Finders.Player.noPlayers')->with('plrNm',$name);
                
            }elseif(count($players)>1){
                // more than one player is found in search results
                //dd($players);
                return view('Finders.Player.manyPlayers')->with(['players'=>$players])->with('plrNm',$name);
                
            }else{
                //one player is found in the search results
                // fetching the villages details from diff table
                $villages=Diff::where('server_id',$players[0]->server_id)
                    ->where('uid',$players[0]->uid)
                    ->orderBy('population','desc')->get();
                //dd($villages);
                return view('Finders.Player.onePlayer')->with(['player'=>$players[0]])
                ->with(['villages'=>$villages])->with('plrNm',$name);
            }            
        }
    }   
    
}
