<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class ServersController extends Controller
{
    public function index(){
        
        session(['title'=>'Servers']);
        return view('Servers.overview');
        
    }
    
    public function process(){
        
        session(['title'=>'Servers']);
        
        $server_id = Input::get('server');
        Session::flash('success','Server: '.$server_id.' is loaded');
        return Redirect::to('/home') ;        
    }
    
    
}
