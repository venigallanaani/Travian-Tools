<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    // this process will display the Contact page

    public function index(){

    	session(['title'=>'About']);
    	return view('About.overview');

    }
}
