<?php

namespace App\Http\Controllers\Calculators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class TradeCalculateController extends Controller
{
    public function display(){
        
        session(['title'=>'Calculators']);
        $input['wood']=0;       $input['clay']=0;       $input['iron']=0;       $input['crop']=0;
        $input['delivery']=0;   $input['frequency']=0;  $input['townhall']=0;   $input['party']='none';

        return view('Calculators.Trade.display')->with(['input'=>$input]);
        
    }
    
    public function calculateTrade(Request $request){
        
        session(['title'=>'Calculators']);
        //dd($request);
    // Setting resources and time meta data arrays   
        $celebration['small']=array('wood'=>6400,   'clay'=>6650,   'iron'=>5940,   'crop'=>1340);
        $celebration['great']=array('wood'=>29700,   'clay'=>33250,   'iron'=>32000,   'crop'=>6700);
        
        $townhall=array(
                0=>array('small'=>null,'great'=>null),          1=>array('small'=>86400,'great'=>null),
                2=>array('small'=>83290,'great'=>null),         3=>array('small'=>80291,'great'=>null),
                4=>array('small'=>77401,'great'=>null),         5=>array('small'=>74614,'great'=>null),
                6=>array('small'=>71928,'great'=>null),         7=>array('small'=>69339,'great'=>null),
                8=>array('small'=>66843,'great'=>null),         9=>array('small'=>64436,'great'=>null),
                10=>array('small'=>62117,'great'=>155291),      11=>array('small'=>59880,'great'=>153301),
                12=>array('small'=>57725,'great'=>144312),      13=>array('small'=>55647,'great'=>139116),
                14=>array('small'=>53643,'great'=>134108),      15=>array('small'=>51712,'great'=>129280),
                16=>array('small'=>49850,'great'=>124626),      17=>array('small'=>48056,'great'=>120140),
                18=>array('small'=>46326,'great'=>115815),      19=>array('small'=>44658,'great'=>111645),
                20=>array('small'=>43050,'great'=>107626)                
        );
        
    // extracting input parameters from POST
        if(Input::has('party')){    $party=Input::get('party'); }else{  $party=null;    }
        
        $th = Input::get('townhall');       $result=array();
        
        $prod['wood']=intval(Input::get('wood'));       $prod['clay']=intval(Input::get('clay'));
        $prod['iron']=intval(Input::get('iron'));       $prod['crop']=intval(Input::get('crop'));
        
        $del = Input::get('deliveries');    $freq = Input::get('frequency');
        
        $input['wood']=$prod['wood'];       $input['clay']=$prod['clay'];       
        $input['iron']=$prod['iron'];       $input['crop']=$prod['crop'];
        $input['delivery']=$del;            $input['frequency']=$freq;      
        $input['townhall']=$th;             $input['party']=$party;
        
        $result['message']=null;
        if($th<10 && $party=='great'){
            $result['message']='Town Hall level not enough for Great Celebration';
            $party=null;
        }
        if($th==0 && ($party!=null || $party!='none')){
            $result['message']='Town Hall level not enough for Celebrations';
            $party=null;
        }
        
        $day['wood']=$prod['wood']*24;      $day['clay']=$prod['clay']*24;
        $day['iron']=$prod['iron']*24;      $day['crop']=$prod['crop']*24; 
        
        $result['del']=$del;
        
        if($freq==1){ $result['freq']='24 hours';   
        }elseif($freq==2){  $result['freq']='12 hours';
        }elseif($freq==3){  $result['freq']='8 hours';
        }elseif($freq==4){  $result['freq']='6 hours';
        }elseif($freq==6){  $result['freq']='4 hours';
        }elseif($freq==8){  $result['freq']='3 hours';
        }elseif($freq==12){  $result['freq']='2 hours';
        }else{  $result['freq']='1 hour';   }
        
        if($party==null){
            
            $result['wood']=floor($day['wood']/($del*$freq));      $result['clay']=floor($day['clay']/($del*$freq));
            $result['iron']=floor($day['iron']/($del*$freq));      $result['crop']=floor($day['crop']/($del*$freq));
            
        }else{
            
            $time = (24*60*60)/$townhall[$th][$party];
            
            $cons['wood']=ceil($celebration[$party]['wood']*$time);       $cons['clay']=ceil($celebration[$party]['clay']*$time);
            $cons['iron']=ceil($celebration[$party]['iron']*$time);       $cons['crop']=ceil($celebration[$party]['crop']*$time);
            
            $result['wood']=floor(($day['wood']-$cons['wood'])/($del*$freq));      $result['clay']=floor(($day['clay']-$cons['clay'])/($del*$freq));
            $result['iron']=floor(($day['iron']-$cons['iron'])/($del*$freq));      $result['crop']=floor(($day['crop']-$cons['crop'])/($del*$freq));  
            
            if($result['wood']<0 || $result['clay']<0 || $result['iron']<0 || $result['crop']<0){
                
                $result['message']=ucfirst($party).' Celebration cannot be supported with the current village production';                
                $result['wood']=floor($day['wood']/($del*$freq));      $result['clay']=floor($day['clay']/($del*$freq));
                $result['iron']=floor($day['iron']/($del*$freq));      $result['crop']=floor($day['crop']/($del*$freq));
                
            }
            
        }
        
        return view('Calculators.Trade.result')->with(['result'=>$result])->with(['input'=>$input]);
        
    }
}
