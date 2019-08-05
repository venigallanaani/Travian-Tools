<?php

namespace App\Http\Controllers\Plus\Artifact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class artifactLeaderController extends Controller
{
    //
    
    public function captureOverview(){
        return view('Plus.Artifacts.capture');
    }
    
}
