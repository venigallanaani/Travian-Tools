<?php

namespace App\Http\Controllers\Finders;

use App\Http\Controllers\Controller;

class FindersController extends Controller
{
    // this process will display the Finders page

    public function index(){

    	session(['title'=>'Finders']);
    	return view('Finders.overview');

    }
}
