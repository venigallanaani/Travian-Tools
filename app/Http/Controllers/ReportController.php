<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class ReportController extends Controller
{
    public function index(){        
        session(['title'=>'TT Reports']);
        return view('Reports.display');
    }
    
    public function makeReport(Request $request){
        session(['title'=>'TT Reports']);
                
        $parseData = ParseReports(Input::get('report'));
        $report = str_random(10);
        
        dd($parseData);
        //dd(Input::get('defender'));
        
        //return view('Reports.reports');
    }
    
    public function showReports(Request $request, $string){
        session(['title'=>'TT Reports']);
        
        //$reports = explode(",", $string);
        //dd($reports);
        
        dd(Input::get('defender'));
    }
}
