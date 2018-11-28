<?php

/* ---------------- controller for home page --------------- */
Route::get('/', 'HomeController@index');					// Displays home page on login
Route::get('/home', 'HomeController@index');				// Displays home page on selection

/* --------------- controller for finders page -------------- */
Route::get('/finder','FindersController@index');			// Finders main page
Route::get('/finder/{task}','FindersController@show');		// Displays the different type of finders

/* --------------- Controller for Account Page -------------- */
Route::get('/account','AccountController@index');			// Account main page
Route::get('/account/{task}','AccountController@show');		// Displays the different options in the account page

/* --------------- Controller for Plus Page ----------------- */
Route::get('/plus','PlusController@index');					// Plus Menu main page	
Route::get('/plus/{task}/{id?}','PlusController@show');			// Shows different option view in the plus General page

/* --------------- Controller for Plus leader menu --------------- */
Route::get('/leader/{task?}','PlusController@leader');	

/* --------------- Controller for Plus Resource leader menu --------------- */
Route::get('/resource/{task?}','PlusController@resource');	

/* --------------- Controller for the Report Page ----------- */
Route::get('/report','ReportController@index');				// Displays the Report Page
Route::post('/report','ReportController@process');			// Creates the Defect / bug in the Database

/* --------------- Controller for the Contact Page ------------ */
Route::get('/contact','ContactController@index');			//Displays the contact page