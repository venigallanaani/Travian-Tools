<?php

namespace App\Http\Controllers\Calculators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;


class DistanceController extends Controller
{
    public function travelDisplay(){
        
        return view('Calculators.Travel.distance');        
            
    }
}
