<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    // this process will display the Account page

    public function index(){

    	session(['title'=>'Account']);
    	return view('Account.overview');

    }


    //This process will display the different kinds of finders based on the input

    public function show($id){    	

    	session(['title'=>'Account']);

    	if($id=='troops'){
    		return view('Account.troopsOverview');          //Displays the player finder
    	}elseif($id=='alliance'){
    		return view('Account.allianceOverview');        //Displays the alliance finder
    	}elseif($id=='hero'){
    		return view('Account.heroOverview');           //Displays the natar finder
    	}else{
    		return view('Account.overview');
    	}		
    }
}
