<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class ReportController extends Controller
{
    public function index(){        
        session(['title'=>'Reports']);
        return view('Reports.display');
    }
    
    public function makeReport(Request $request){
        session(['title'=>'Reports']);
                
        $parseData = ParseReports(Input::get('report'));
        $report = str_random(10);
        
        dd($parseData);
        
        //return view('Reports.reports');
    }
}
