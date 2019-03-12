<?php

namespace App\Http\Controllers\Calculators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class CropperController extends Controller
{
    public function display(){
        
        return view('Calculators.Cropper.Display');
        
    }
    
    public function process(){
        
        // converts the alliance finder post call into get
        $crop  = Input::get('cropper') ;  
        
        if(Input::get('capital')==null){
            $cap=0;
        }else{
            $cap=1;
        }
        if(Input::get('plus')==null){
            $plus=0;
        }else{
            $plus=1;
        }
        
        $oasis1  = Input::get('oasis1') ;
        $oasis2  = Input::get('oasis2') ;
        $oasis3 = Input::get('oasis3') ;
        
        $total = $oasis1+$oasis2+$oasis3;
        
        if($total==125){
            $oasis1=50; $oasis2=50; $oasis3=25;
        }        
        if($total==100){
            if($oasis1==25 || $oasis2==25 || $oasis3==25){
                $oasis1=50; $oasis2=25; $oasis3=25;
            }else{
                $oasis1=50; $oasis2=50; $oasis3=0;
            }
        }        
        if($total==75){
            if($oasis1==50 || $oasis2==50 || $oasis3==50){
                $oasis1=50; $oasis2=25; $oasis3=0;
            }else{
                $oasis1=25; $oasis2=25; $oasis3=25;
            }
        }        
        if($total==50){
            if($oasis1==50 || $oasis2==50 || $oasis3==50){
                $oasis1=50; $oasis2=0; $oasis3=0;
            }else{
                $oasis1=25; $oasis2=25; $oasis3=0;
            }
        }        
        if($total==25){
            $oasis1=25; $oasis2=0; $oasis3=0;
        }        
        
        return Redirect::to('/calculators/cropper/'.$crop.'/'.$cap.'/'.$oasis1.'/'.$oasis2.'/'.$oasis3.'/'.$plus) ;
        
    }
    
    
    public function calculate($crop,$cap,$o1,$o2,$o3,$plus, Request $request){
        
        if($plus == 0){ $plus = 1;
        }else{  $plus=1.25; }
        
        if($cap == 0){  $cap = 10;
        }else{  $cap = 21;  }
        
        // costs of the bonus buildings constructions
        $costs = array();         
        $cost['mill'] = array(0,2560,4605,8295,14925,26875);
        $cost['bakery'] = array(0,5150,9270,16690,30035,54060);
        $cost['hero'] = array(0,114240,383315,1595070);
                
        // crop fields and the values;
        $fields['prod'] = array(3,7,13,21,31,46,70,98,140,203,280,392,525,691,889,1120,1400,1820,2240,2800,3430,4270);
        $fields['cost'] = array(0,250,415,695,1165,1945,3250,5425,9055,15125,25255,42180,70445,117650,196445,328070,547880,914960,1527985,2551735,4261410,7116555);
        $fields['increase'] = array(0,4,6,8,10,15,24,28,42,63,77,112,133,168,196,231,280,420,420,560,630,840);
        
        if($crop==15){
            $fields['fields']=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
        }else if($crop == 9){
            $fields['fields']=array(0,0,0,0,0,0,0,0,0);
        }else if($crop == 7){
            $fields['fields']=array(0,0,0,0,0,0,0);
        }else{
            $fields['fields']=array(0,0,0,0,0,0);
        }
                
        return view('Calculators.Cropper.Results');
        
    }
    
}
