<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
   	// this process will display the Finders page

    public function index(){

    	session(['title'=>'Report']);
    	return view('Report.overview');

    }

    public function process($request){

    	session(['title'=>'Report']);
    	return view('Report.overview');
    }
}
