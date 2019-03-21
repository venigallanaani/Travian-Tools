<?php

namespace App\Http\Controllers\Calculators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function overview(){
    
        session(['title'=>'Calculators']);
        return view('Calculators.overview');
        
    }
}
