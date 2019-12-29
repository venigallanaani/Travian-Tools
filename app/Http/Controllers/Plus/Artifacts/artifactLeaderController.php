<?php

namespace App\Http\Controllers\Plus\Artifacts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

use App\ArtList;

class artifactLeaderController extends Controller
{
    //
    
    public function captureDisplay(){
        
        session(['title'=>'Artifacts']);
        
        $list = ArtList::orderBy('aid','asc')->get();        
        
        $artyGrp = null;   $i=1;
        foreach($list as $row){
            if($i!=$row->grp){
                $i++;
            }            
            
            $arty = array(
                'ID' => $row->aid,
                'NAME'=> $row->name,
                'DESC'=>$row->description,
                'SIZE'=>$row->size
            );
            
            $artyGrp[$i][]=$arty;
            
        }
//dd($artyGrp);
        return view('Plus.Artifacts.Capture.display')->with(['group'=>$artyGrp]);
    }
    
    
    public function captureResult(Request $result){
        
        $artys = ArtList::orderBy('aid','asc')->get();
        
        $input=array();
        
        $input['SMALL']=Input::get('smHammer');
        $input['LARGE']=Input::get('lqHammer');
        $input['UNIQUE']=Input::get('unHammer');
        
        foreach($artys as $arty){
            
            $x = $arty->aid.'_x';   $y = $arty->aid.'_y';
            
            if(!(Input::get($x)==null) && !(Input::get($y)==null)){
                
                $input[$arty->aid]['X']=Input::get($x);
                $input[$arty->aid]['Y']=Input::get($y);
                $input[$arty->aid]['NAME']=$arty->name;
                $input[$arty->aid]['SIZE']=$arty->size;
                $input[$arty->aid]['PTY']=Input::get($arty->aid.'_priority');
            }
            
            
        }       
        
        return view('Plus.Artifacts.Capture.result')->with(['result'=>$input]);
        
    }
    
}
