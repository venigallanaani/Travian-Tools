<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    // this process will display the Contact page

    public function index(){

    	session(['title'=>'Contacts']);
    	return view('Contact.overview');

    }
}
