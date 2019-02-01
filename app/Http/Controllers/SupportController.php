<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;

use App\Support;

class SupportController extends Controller
{
   	// this process will display the Finders page

    public function index(){

    	session(['title'=>'Support']);
    	return view('Support.overview');

    }

    public function process(Request $request){

    	session(['title'=>'Support']);
    	
    	$ticket = new Support;
    	
    	$ticket->subject=Input::get('subject');
    	$ticket->email=Input::get('email');
    	$ticket->type=Input::get('type');
    	$ticket->description=Input::get('description');
    	$ticket->status='New';
    	
    	$ticket->save();
    	
    	
    	Session::flash('success','Thank you, your suggestion is received successfully.');
    	
    	return view('Support.overview');    	
    }
}
