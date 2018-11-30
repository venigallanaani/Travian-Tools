<?php

/* ---------------- Home page --------------- */
Route::get('/', 'HomeController@index');					// Displays home page on login
Route::get('/home', 'HomeController@index');				// Displays home page on selection

/* --------------- Finders page -------------- */
Route::get('/finder','FindersController@index');			// Finders main page

Route::get('/finder/player','FindersController@player');		    // Displays the different type of finders
Route::post('/finder/player','FindersController@processPlayer');		// Displays the different type of finders
Route::get('/finder/player/{name}/{id?}','FindersController@player');		    // Displays the different type of finders

Route::get('/finder/alliance','FindersController@alliance');		// Displays the different type of finders
Route::post('/finder/alliance','FindersController@processAlliance');	// Displays the different type of finders
Route::get('/finder/alliance/{name}/{id?}','FindersController@alliance');	// Displays the different type of finders

Route::get('/finder/inactive','FindersController@inactive');		// Displays the different type of finders
Route::post('/finder/inactive','FindersController@processInactive');		// Displays the result of the inactive finders

Route::get('/finder/natar','FindersController@natar');		        // Displays the different type of finders
Route::post('/finder/natar','FindersController@processNatar');		// Displays the result of the Natar finders

Route::get('/finder/neighbour','FindersController@neighbour');		// Displays the different type of finders
Route::post('/finder/neighbour','FindersController@processNeighbour');		// Displays the result of the neighbour finders


/* --------------- Controller for Account Page -------------- */
Route::get('/account','AccountController@index');			// Account main page
Route::get('/account/{task}','AccountController@show');		// Displays the different options in the account page

/* --------------- Plus Page -- General Options ----------------- */
Route::get('/plus','PlusController@index');					// Plus Menu main page	
Route::get('/plus/{task}/{id?}','PlusController@show');			// Shows different option view in the plus General page

/* --------------- Controller for Plus leader menu --------------- */
Route::get('/leader/{task?}','LeaderController@leader');	

/* --------------- Plus Resource leader menu --------------- */
Route::get('/resource/{task?}','ResourceController@resource');	
Route::post('/resource/{task?}','ResourceController@processResourceTask');	

/* --------------- Plus Resource leader menu --------------- */
Route::get('/defense/incoming','DefenseController@incoming');
Route::post('/defense/incoming','DefenseController@processIncoming');

Route::get('/defense/cfd','DefenseController@cfdList');
Route::post('/defense/cfd','DefenseController@createCfd');
Route::get('/defense/cfd/{id}','DefenseController@cfdDetail');
Route::post('/defense/cfd/{id}','DefenseController@processCfd');

Route::get('/defense/search','DefenseController@search');
Route::post('/defense/search','DefenseController@processSearch');


/* --------------- Controller for the Report Page ----------- */
Route::get('/report','ReportController@index');				// Displays the Report Page
Route::post('/report','ReportController@process');			// Creates the Defect / bug in the Database

/* --------------- Controller for the Contact Page ------------ */
Route::get('/about','AboutController@index');			//Displays the contact page