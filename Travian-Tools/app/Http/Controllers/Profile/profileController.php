<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class profileController extends Controller
{
    public function overview(Request $request){
        
        session(['title'=>'Profile']);
        
        return view('Profile.overview');
    }
}
