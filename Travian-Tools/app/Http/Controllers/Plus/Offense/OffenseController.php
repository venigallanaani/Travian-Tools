<?php

namespace App\Http\Controllers\Plus\Offense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OffenseController extends Controller
{
    public function offenseTaskList(Request $request){
        
        return view('Plus.Offense.offenseTasks');
        
    }
}
