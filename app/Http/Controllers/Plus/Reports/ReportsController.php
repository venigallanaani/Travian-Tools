<?php

namespace App\Http\Controllers\Plus\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

use App\Diff;
use App\Reports;
use App\Units;
use App\TrackTroops;
use App\PlusReports;

class ReportsController extends Controller
{
    public function showPlusReports(Request $request){
        
        session(['title'=>'Plus']);       
        
        $reports = PlusReports::where('plus_id',$request->session()->get('plus.plus_id'))
                        ->orderBy('date','desc')->get();
        
        $reports = $reports->toArray();
        
        return view('Plus.Reports.reports')->with(['reports'=>$reports]);
        
    }
    
    public function addPlusReports(Request $request){
        
        $link = Input::get('link');        
        
        if(strpos($link,env('SITE_URL'))!== FALSE){            
            $links = explode(',',substr($link, strrpos($link, '/') + 1));    
            
            $reports = Reports::where('id',$links[0])->where('type','STATS')->first();
            
            $save = new PlusReports;
            
            $save->plus_id = $request->session()->get('plus.plus_id');
            $save->title = $reports->subject;;
            $save->report = $link;
            $save->date =  Carbon::now()->format('Y-m-d');
            
            $save->save();
            
            Session::flash('success','Report added successfully');            
            
        }else{
            Session::flash('danger','Report not found');
        }                
        return Redirect::back();          
    }
    
    public function showLeaderReports(Request $request){
        
        session(['title'=>'Plus']);
        
        $reports = PlusReports::where('plus_id',$request->session()->get('plus.plus_id'))
                        ->orderBy('date','desc')->get();
        
        $reports = $reports->toArray();
        
        return view('Plus.Reports.leaderReports')->with(['reports'=>$reports]);
        
    }
    
    public function deleteLeaderReports(Request $request, $id){
        PlusReports::where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('id',$id)->delete();
    }
    
    
    public function showEnemyHammers(Request $request){
        
        session(['title'=>'Plus']);
        
        $troops = TrackTroops::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->orderBy('report_date','desc')->get();        
        $troops = $troops->toArray();
        
        $hammers=array();    $units=array();     $i=0;
        
        $rows = Units::all();
        $rows = $rows->toArray();
        
        foreach($rows as $row){
            $units[$row['tribe_id']][$i] = $row['image'];            
            if($i>=9){  $i=0;
            }else{  $i++;   }            
        }
        
        foreach($troops as $troop){
            
            $troop['report_data'] = explode('|',$troop['report_data']);
            $village = Diff::where('server_id',$request->session()->get('server.id'))
                            ->where('vid',$troop['vid'])->pluck('village');
            $troop['village']=$village[0];
            $hammers[] = $troop;
            
        }
        
        //dd($hammers);
        return view('Plus.Reports.enemyHammers')->with(['units'=>$units])->with(['hammers'=>$hammers]);
        
    }
    
    public function addEnemyHammer(Request $request) {
        session(['title'=>'Plus']);
        
        $x = Input::get('xCor');            $y = Input::get('yCor');
        $type = Input::get('type');         $date = Input::get('date');
        $id = Input::get('report');         $notes = Input::get('notes');
        
        $id = explode(',',substr($id, strrpos($id, '/') + 1))[0];
                
        if($date == null){
            $date = Carbon::now()->format('Y-m-d');
        }
        
        $village = Diff::where('server_id',$request->session()->get('server.id'))
                        ->where('x',$x)->where('y',$y)->first();
        if($village == null){
            Session::flash('danger','Enemy village not found');
            return Redirect::back();
        }
        
        if($type=='SCOUT'){
            $reports=Reports::where('id',$id)->where('type','DEFEND')->first();            
            if($reports == null){
                Session::flash('danger','Report not found');
                return Redirect::back();
            }            
            $reportData=$reports->stat1;
        }
        if($type=='ATTACK'){
            $reports=Reports::where('id',$id)->where('type','ATTACK')->first();
            if($reports == null){
                Session::flash('danger','Report not found');
                return Redirect::back();
            }    
            $reportData=$reports->stat3;
        }
        if($type=='DEFEND'){
            $reports=Reports::where('id',$id)->where('type','DEFEND')->first();
            if($reports == null){
                Session::flash('danger','Report not found');
                return Redirect::back();
            }    
            $reportData=$reports->stat3;
        }
        
        $units = Units::where('tribe_id',$village->id)->orderBy('id','asc')->get();
        $units = $units->toArray();
        
        $troops = explode('|',$reportData);
        $upkeep = 0;
        for($i=0;$i<count($units);$i++){
            if($units[$i]['type']=='O' || $units[$i]['type']=='S'){
                $upkeep+=$units[$i]['upkeep']*$troops[$i];
            }       
            
        }
        
        $track = new TrackTroops();
        
        $track->server_id = $request->session()->get('server.id');
        $track->plus_id = $request->session()->get('plus.plus_id');
        $track->att_id = $village->uid.'_'.$village->vid;
        $track->x = $x;     
        $track->y = $y;     
        $track->vid = $village->vid;    
        $track->uid = $village->uid;    
        $track->player = $village->player; 
        $track->alliance = $village->alliance;
        $track->tribe = $village->id;
        $track->type = $type;
        $track->report_date = $date;
        $track->report = $id;
        $track->upkeep = $upkeep;
        $track->report_data = $reportData;
        $track->notes = $notes;
        
        $track->save();
        
        return Redirect::back();
    }
    
    public function deleteEnemyHammer(Request $request, $id){
        
        TrackTroops::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('id',$id)->delete();
        
    }
}



