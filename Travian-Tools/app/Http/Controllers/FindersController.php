<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;

use App\Diff;
use App\Players;
use App\Alliances;
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
            // displays player finder form
            return view('finders.Player.playerFinder');
        }else{            
            if($id==null){
                $players=Players::where('player','like','%'.$name.'%')
                    ->where('server_id','t6angr1')
                    ->orderBy('rank','asc')->get();
            }else{
                $players=Players::where('player','=',$name)
                    ->where('server_id','t6angr1')->get();
            }
            
            if(count($players)==0){
                // no players are found in search results
                return view('Finders.Player.noPlayers')->with('player',$name);
                
            }elseif(count($players)>1){
                // more than one player is found in search results
                //dd($players);
                return view('finders.Player.manyPlayers')->with(['players'=>$players]);
                
            }else{
                //one player is found in the search results
                // fetching the villages details from diff table
                $villages=Diff::where('server_id',$players[0]->server_id)
                    ->where('uid',$players[0]->uid)
                    ->orderBy('population','desc')->get();
                //dd($villages);
                return view('finders.Player.onePlayer')->with(['player'=>$players[0]])
                            ->with(['villages'=>$villages]);
            }            
        }
    }   
    
    public function alliance($name=null,$id=null){
        //Displays the alliance finder
        if($id==null && $name==null){
            return view('finders.Alliance.allianceFinder');
        }else{
            if($id==null){
                $alliances=Alliances::where('alliance','like','%'.$name.'%')
                                ->where('server_id','t6angr1')
                                ->orderBy('rank','asc')->get();
            }else{
                $alliances=Alliances::where('alliance','=',$name)
                                ->where('server_id','t6angr1')->get();
            }
            
            if(count($alliances)==0){
                // no players are found in search results
                return view('Finders.Alliance.noAlliance')->with('alliance',$name);
                
            }elseif(count($alliances)>1){
                // more than one player is found in search results
                //dd($players);
                return view('finders.Alliance.manyAlliances')->with(['alliances'=>$alliances]);                
            }else{
                //one player is found in the search results
                // fetching the villages details from diff table
                $players=Players::where('server_id',$alliances[0]->server_id)
                            ->where('aid',$alliances[0]->aid)
                            ->orderBy('population','desc')->get();
                //dd($villages);
                return view('finders.Alliance.oneAlliance')->with(['alliance'=>$alliances[0]])
                            ->with(['players'=>$players]);
            }
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
        //Process the Natar finder form
        
        $xCor=Input::get('xCor');
        $yCor=Input::get('yCor');
        $dist = Input::get('dist');
        
        $sqlStr = "SELECT a.* FROM maps_details a, servers b WHERE a.table_id = b.table_id AND b.server_id='".'t6angr1'."' and".
            " ((".$xCor."- a.x)*(".$xCor."- a.x) + (".$yCor."- a.y)*(".$yCor."- a.y)) <= ".$dist."*".$dist." AND uid=1 ".
            " ORDER BY "."((".$xCor."- a.x)*(".$xCor."- a.x) + (".$yCor."- a.y)*(".$yCor."- a.y)) ASC";
                
        $natars= DB::select(DB::raw($sqlStr));        
        //dd($natars);
        if(count($natars)==0){
            return view('finders.Natar.noNatar');
        }else{
            return view('finders.Natar.natarList')->with(['natars'=>$natars])
                    ->with(['x'=>$xCor])->with(['y'=>$yCor])->with(['dist'=>$dist]);
        }                
    }
    
    public function inactive(){
        //Displays the inactive finder
        return view('finders.Inactive.inactiveFinder');
    }
    
    public function processInactive(Request $request){
        //Displays the inactive finder        
        $xCor=Input::get('xCor');
        $yCor=Input::get('yCor');
        $dist = Input::get('dist');
        $pop=Input::get('pop');
        
        
        $sqlStr = "SELECT a.* FROM diff_details a, servers b WHERE a.table_id = b.table_id AND b.server_id='".'t6angr1'."' AND".
            " ((".$xCor."- a.x)*(".$xCor."- a.x) + (".$yCor."- a.y)*(".$yCor."- a.y)) <= ".$dist."*".$dist.
            " AND a.population <=".$pop." AND a.status <> 'Active'".
            " ORDER BY "."((".$xCor."- a.x)*(".$xCor."- a.x) + (".$yCor."- a.y)*(".$yCor."- a.y)) ASC";
        
        $villages= DB::select(DB::raw($sqlStr));
        //dd($natars);
        if(count($villages)==0){
            return view('finders.Inactive.noInactive');
        }else{
            return view('finders.Inactive.inactivelist')->with(['villages'=>$villages])
            ->with(['x'=>$xCor])->with(['y'=>$yCor])->with(['dist'=>$dist]);
        }
    }
    
    public function neighbour(){        
        //Displays the neighbour finder
        return view('finders.Neighbour.neighbourFinder');
    }
    
    public function processNeighbour(Request $request){
        //Process the Neighbour finder form
        
        $xCor=Input::get('xCor');
        $yCor=Input::get('yCor');
        $dist = Input::get('dist');      
        
        
        $sqlStr = "SELECT a.* FROM maps_details a, servers b WHERE a.table_id = b.table_id AND b.server_id='".'t6angr1'."' and".
            " ((".$xCor."- a.x)*(".$xCor."- a.x) + (".$yCor."- a.y)*(".$yCor."- a.y)) <= ".$dist."*".$dist.
            " ORDER BY "."((".$xCor."- a.x)*(".$xCor."- a.x) + (".$yCor."- a.y)*(".$yCor."- a.y)) ASC";
        
        $villages= DB::select(DB::raw($sqlStr));
        //dd($natars);
        if(count($villages)==0){
            return view('finders.Neighbour.noNeighbours');
        }else{
            return view('finders.Neighbour.neighbourslist')->with(['villages'=>$villages])
            ->with(['x'=>$xCor])->with(['y'=>$yCor])->with(['dist'=>$dist]);
        }           
    }
}
