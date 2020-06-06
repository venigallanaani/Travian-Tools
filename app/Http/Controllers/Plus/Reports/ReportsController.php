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
// Show the plus reports to the players in the general plus menu
    public function showPlusReports(Request $request){
        
        session(['title'=>'Plus']);   
        
        $reports = PlusReports::where('plus_id',$request->session()->get('plus.plus_id'))
                        ->orderBy('date','desc')->get();
        
        $reports = $reports->toArray();
        foreach($reports as $i=>$report){
            $reports[$i]['date']=Carbon::parse($report['date'])->format(explode(' ',$request->session()->get('dateFormat'))[0]);
        }
        //dd($reports);
        return view('Plus.Reports.reports')->with(['reports'=>$reports]);
        
    }
    
// Submits the reports created by the players to the plus group
    public function addPlusReports(Request $request){
        
        session(['title'=>'Reports']);
        
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
            
            Session::flash('success','Report added');            
            
        }else{
            Session::flash('danger','Report not found');
        }                
        return Redirect::back();          
    }
    
// Show the leader view of the reports in the leader reports menu - delete option added.
    public function showLeaderReports(Request $request){
        
        session(['title'=>'Reports']);
        session(['menu'=>2]);
        $reports = PlusReports::where('plus_id',$request->session()->get('plus.plus_id'))
                        ->orderBy('date','desc')->get();
        
        $reports = $reports->toArray();
        foreach($reports as $i=>$report){
            $reports[$i]['date']=Carbon::parse($report['date'])->format(explode(' ',$request->session()->get('dateFormat'))[0]);
        }
        return view('Plus.Reports.leaderReports')->with(['reports'=>$reports]);
        
    }
    
// Lets leaders delete the reports from the group
    public function deleteLeaderReports(Request $request, $id){
        session(['menu'=>2]);
        PlusReports::where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('id',$id)->delete();
    }
    
// Lists the hammers that are being tracked by the group and their scout reports.    
    public function showEnemyHammers(Request $request){
        
        session(['title'=>'Reports']);
        session(['menu'=>2]);
        $troops = TrackTroops::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('status','REPORT')->orderBy('report_date','desc')->get();        
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
            $troop['report_date']=Carbon::parse($troop['report_date'])->format(explode(' ',$request->session()->get('dateFormat'))[0]);
            
            $hammers[] = $troop;            
        }        

        return view('Plus.Reports.enemyHammers')->with(['units'=>$units])->with(['hammers'=>$hammers]);
        
    }
    
// New enemy hammers to be tracked to the list.
    public function addEnemyHammer(Request $request) {
        session(['title'=>'Reports']);
        session(['menu'=>2]);
        
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
        
        $results = TrackTroops::where('server_id',$request->session()->get('server.id'))
                                ->where('plus_id',$request->session()->get('plus.plus_id'))
                                ->where('att_id',$village->uid.'_'.$village->vid)
                                ->orderBy('updated_at','desc')->get();      
                
        if(count($results)==0){
            $track = new TrackTroops();
            
            $track->server_id = $request->session()->get('server.id');
            $track->plus_id = $request->session()->get('plus.plus_id');
            $track->att_id = $village->uid.'_'.$village->vid;
            $track->status = 'REPORT';
            $track->x = $x;
            $track->y = $y;
            $track->vid = $village->vid;
            $track->uid = $village->uid;
            $track->player = $village->player;
            $track->alliance = $village->alliance;
            $track->tribe = $village->id;
            $track->tsq = 0;
            $track->art = 4;
            $track->type = $type;
            $track->report_date = $date;
            $track->report = $id;
            $track->upkeep = $upkeep;
            $track->report_data = $reportData;
            $track->notes = $notes;
            
            $track->save();
            
        }else{
            $result= $results[0];
    
            if(count($results)==1 && $result->status="TRACK"){
    // if no reports are present update the existing report
                TrackTroops::where('server_id',$request->session()->get('server.id'))
                                ->where('plus_id',$request->session()->get('plus.plus_id'))
                                ->where('att_id',$village->uid.'_'.$village->vid)
                                ->update([  'status'    =>  'REPORT',
                                    'type'      =>  $type,
                                    'report_date'   =>  $date,
                                    'report'    =>  $id,
                                    'upkeep'    =>  $upkeep,
                                    'report_data'   =>  $reportData,
                                    'notes'     =>  $notes
                                ]);
            
            }else{
    // if a report exists .. add new report with tsq and arty value from previous report
                $track = new TrackTroops();
                
                $track->server_id = $request->session()->get('server.id');
                $track->plus_id = $request->session()->get('plus.plus_id');
                $track->att_id = $village->uid.'_'.$village->vid;
                $track->status = 'REPORT';
                $track->x = $x;
                $track->y = $y;
                $track->vid = $village->vid;
                $track->uid = $village->uid;
                $track->player = $village->player;
                $track->alliance = $village->alliance;
                $track->tribe = $village->id;
                $track->tsq = $result->tsq;
                $track->art = $result->art;
                $track->type = $type;
                $track->report_date = $date;
                $track->report = $id;
                $track->upkeep = $upkeep;
                $track->report_data = $reportData;
                $track->notes = $notes;
                
                $track->save();  
            }
        }
        
        return Redirect::back();
    }
    
// update or delete the tracked enemies
    public function processEnemyHammer(Request $request,$action,$id,$value=null){
        session(['menu'=>2]);
    // update the Tsq of the player
        if(strtoupper($action)=='TSQ'){
            $track=TrackTroops::where('server_id',$request->session()->get('server.id'))
                                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                                    ->where('id',$id)->first();
            
            TrackTroops::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))
                            ->where('att_id',$track->att_id)
                            ->update(['tsq'=>$value]);
        }
    // update the artifact of the player
        if(strtoupper($action)=='ART'){
            $track=TrackTroops::where('server_id',$request->session()->get('server.id'))
                                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                                    ->where('id',$id)->first();
            
            TrackTroops::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))
                            ->where('att_id',$track->att_id)
                            ->update(['art'=>$value]);
        }
        
    // delete enemy hammer report -- deletes the link and sets the status to TRACK
        if(strtoupper($action)=='DELETE'){
            TrackTroops::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))
                            ->where('id',$id)
                            ->update([  'status'=>'TRACK'   ]);            
        }        

        
    }
}



