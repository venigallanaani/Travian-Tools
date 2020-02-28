<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

use App\Account;
use App\Players;
use App\Diff;
use App\Villages;

class VillagesController extends Controller
{
    // this process will display the Account page

    public function villagesOverview(Request $request){

    	session(['title'=>'Account']);
    	
    	if(!$request->session()->has('server.id')){  
    	    return view('Account.template');
    	}    	
    	    
	    $account=Account::where('server_id',$request->session()->get('server.id'))
	                   ->where('user_id',Auth::user()->id)->first();
//dd($account);
        if($account==null){
           
            Session::flash('warning', 'No associated account is found on travian server '.$request->session()->get('session.url'));
            return view('Account.addAccount')->with(['players'=>null]);
           
        }else{
            $villages = null;
            
            $diffs = Diff::where('server_id',$request->session()->get('server.id'))
	                               ->where('uid',$account->uid)->get();
            $vills = Villages::where('server_id',$request->session()->get('server.id'))
	                               ->where('account_id',$account->account_id)->get();
//dd($diffs);

            foreach($diffs as $diff){
                $villages[$diff->vid]['NAME']=$diff->village;
                $villages[$diff->vid]['VID']=$diff->vid;
                $villages[$diff->vid]['CAP']=null;
                $villages[$diff->vid]['X']=$diff->x;
                $villages[$diff->vid]['Y']=$diff->y;
                $villages[$diff->vid]['TILES']='4-4-4-6';
                $villages[$diff->vid]['FIELD']=0;
                $villages[$diff->vid]['WOOD']=0;
                $villages[$diff->vid]['CLAY']=0;
                $villages[$diff->vid]['IRON']=0;
                $villages[$diff->vid]['CROP']=0;
                $villages[$diff->vid]['PROD']=54;
                $villages[$diff->vid]['ART']='NONE';
            }
	                               
            if(count($vills) > 0){

                foreach($vills as $vill){
                    $villages[$vill->vid]['CAP']=$vill->cap;
                    $villages[$vill->vid]['TILES']=$vill->tiles;
                    $villages[$vill->vid]['FIELD']=$vill->field;
                    $villages[$vill->vid]['WOOD']=$vill->wood;
                    $villages[$vill->vid]['CLAY']=$vill->clay;
                    $villages[$vill->vid]['IRON']=$vill->iron;
                    $villages[$vill->vid]['CROP']=$vill->crop;
                    $villages[$vill->vid]['PROD']=$vill->prod;
                    $villages[$vill->vid]['ART']=$vill->artifact;
                }
            }
            
//dd($villages);
            
            return view('Account.villages')->with(['villages'=>$villages]);
	    }
    	
    }    

// Updates the villages details in the account page.
    public function updateVillages(Request $request){
        
        $prod = array(3,7,13,21,31,46,70,98,140,203,280,392,525,691,889,1120,1400,1820,2240,2800,3430,4270);
        
//dd($request);
        $account=Account::where('server_id',$request->session()->get('server.id'))
                            ->where('user_id',Auth::user()->id)->first();
        
        
        $villages = Diff::where('server_id',$request->session()->get('server.id'))
                            ->where('uid',$account->uid)->get();
        
        // Gathering all the input elements
        $input = null;  $i=0;   $cap=0;
        foreach($villages as $village){
            
            $input[$i]['VID']=$village->vid;
            $var = $village->vid."_cap";
            if(Input::get($var)!=null){
                $input[$i]['CAP']=TRUE;
                $cap++;
            }else{
                $input[$i]['CAP']=FALSE;
            }
            
            $tiles = $village->vid."_tiles";
            $input[$i]['TILES']=Input::get($tiles);
            
            $field = $village->vid."_field";
            $input[$i]['FIELD']=Input::get($field);
            
            $wood = $village->vid."_wood";
            $input[$i]['OASIS']['WOOD']=Input::get($wood);
            
            $clay = $village->vid."_clay";
            $input[$i]['OASIS']['CLAY']=Input::get($clay);
            
            $iron = $village->vid."_iron";
            $input[$i]['OASIS']['IRON']=Input::get($iron);
            
            $crop = $village->vid."_crop";
            $input[$i]['OASIS']['CROP']=Input::get($crop);        
            
            $art = $village->vid."_art";
            $input[$i]['ART']=Input::get($art); 
            
            $i++;
        }
//dd($input);   
        if($cap>1){
            Session::flash('danger', 'Cannot update, more than one village is selected as Capital');
            return Redirect::back();
        }
        
        
        foreach($input as $data){
        // checking the field levels of non cap villages
            if($data['CAP']==FALSE && $data['FIELD']>10){
                Session::flash('warning', 'Non capital village field level selected more than 10, update of the village skipped');
            }else{
                
                $tiles=explode('-',$data['TILES']);
                
                $wood = $tiles[0]*(1+$data['OASIS']['WOOD']/100)*$prod[$data['FIELD']];      
                $clay = $tiles[1]*(1+$data['OASIS']['CLAY']/100)*$prod[$data['FIELD']];
                $iron = $tiles[2]*(1+$data['OASIS']['IRON']/100)*$prod[$data['FIELD']];      
                $crop = $tiles[3]*(1+$data['OASIS']['CROP']/100)*$prod[$data['FIELD']];
                
            //Calculating the Production
                if($data['FIELD']>=10){
                    $res = ($wood+$clay+$iron)*1.25+$crop*1.5;
                }else if($data['FIELD']>=5 && $data['FIELD'] < 10){
                    $res = $wood+$clay+$iron+$crop*1.25;
                }else{
                    $res = $wood+$clay+$iron+$crop;
                }
                
                $village = Villages::where('server_id', $request->session()->get('server.id'))
                                ->where('account_id', $account->account_id)
                                ->where('vid', $data['VID'])->first();
//dd($village);
                if($village==null){
                    $village = new Villages;
                    
                    $village->server_id=$request->session()->get('server.id');
                    $village->account_id=$account->account_id;
                    $village->vid=$data['VID'];
                    $village->tiles=$data['TILES'];
                    $village->wood=$data['OASIS']['WOOD'];
                    $village->clay=$data['OASIS']['CLAY'];
                    $village->iron=$data['OASIS']['IRON'];
                    $village->crop=$data['OASIS']['CROP'];
                    $village->prod=$res;
                    $village->cap=$data['CAP'];
                    $village->field=$data['FIELD'];
                    $village->artifact=$data['ART'];
                    
                    $village->save();
                }else{
                    
                    Villages::where('server_id', $request->session()->get('server.id'))
                                    ->where('account_id', $account->account_id)
                                    ->where('vid', $data['VID'])
                                ->update([
                                    'tiles'=>$data['TILES'],
                                    'wood'=>$data['OASIS']['WOOD'],
                                    'clay'=>$data['OASIS']['CLAY'],
                                    'iron'=>$data['OASIS']['IRON'],
                                    'crop'=>$data['OASIS']['CROP'],
                                    'prod'=>$res,
                                    'cap'=>$data['CAP'],
                                    'field'=>$data['FIELD'], 
                                    'artifact'=>$data['ART']
                                ]);
 
                }
            }           
            
        }      
        Session::flash('success',"Village details are successfully updated");
        
        return Redirect::back();

    }
   

}
