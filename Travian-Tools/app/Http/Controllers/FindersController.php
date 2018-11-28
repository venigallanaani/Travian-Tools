<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FindersController extends Controller
{
    // this process will display the Finders page

    public function index(){

    	session(['title'=>'Finders']);
    	return view('finders.overview');

    }


    //This process will display the different kinds of finders based on the input

    public function show($id){    	

    	session(['title'=>'Finders']);

    	if($id=='player'){
    		return view('finders.playerFinder');          //Displays the player finder
    	}elseif($id=='alliance'){
    		return view('finders.allianceFinder');        //Displays the alliance finder
    	}elseif($id=='natar'){
    		return view('finders.natarFinder');           //Displays the natar finder
    	}elseif($id=='inactive'){
    		return view('finders.inactiveFinder');        //Displays the inactive finder 
    	}elseif($id=='neighbour'){
    		return view('finders.neighbourFinder');       // Displays the neighbour finder
    	}else{
    		return view('finders.overview');
    	}		
    }
}
