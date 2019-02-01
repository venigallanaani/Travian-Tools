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

class AllianceFinderController extends Controller
{

    public function alliance($name=null,$id=null,Request $request){
        //Displays the alliance finder
        if($id==null && $name==null){
            return view('Finders.Alliance.allianceFinder');
        }else{
            if($id==null){
                $alliances=Alliances::where('alliance','like','%'.$name.'%')
                            ->where('server_id',$request->session()->get('server.id'))
                            ->orderBy('rank','asc')->paginate(5);
            }else{
                $alliances=Alliances::where('alliance','=',$name)
                            ->where('server_id',$request->session()->get('server.id'))->get();
            }
            
            if(count($alliances)==0){
                // no players are found in search results
                return view('Finders.Alliance.noAlliance')->with('alliance',$name);
                
            }elseif(count($alliances)>1){
                // more than one player is found in search results
                //dd($players);
                return view('Finders.Alliance.manyAlliances')->with(['alliances'=>$alliances]);                
            }else{
                //one player is found in the search results
                // fetching the villages details from diff table
                $players=Players::where('server_id',$alliances[0]->server_id)
                            ->where('aid',$alliances[0]->aid)
                            ->orderBy('population','desc')->get();
                //dd($villages);
                return view('Finders.Alliance.oneAlliance')->with(['alliance'=>$alliances[0]])
                            ->with(['players'=>$players]);
            }
        }
    }
    
    public function processAlliance(){
        // converts the alliance finder post call into get
        $name  = Input::get('allyNm') ;
        return Redirect::to('/finder/alliance/'.$name) ;
    }   

}
