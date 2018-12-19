<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Account;

class AccountController extends Controller
{
    // this process will display the Account page

    public function displayOverview(Request $request){

    	session(['title'=>'Account']);
    	
    	$account=Account::where('server_id',$request->session()->get('session.id'))
    	           ->where('user_id',$request->session()->get('plus.plus_id'))->get();
    	
    	if($account==null){
    	    return view('Account.overview')->with(['account'=>$account]);
    	}else{
    	    return view('Account.overview');
    	}  	

    }


    //This process will display the different kinds of finders based on the input


}
