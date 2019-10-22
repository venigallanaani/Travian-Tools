<?php

/* ----------------------------------------------------------------------------- */
/* ------------------------------- Reports page controllers -------------------- */
/* ----------------------------------------------------------------------------- */
Route::get('/','ReportController@index')->name('reports');
Route::get('/home','ReportController@index')->name('reports');
Route::get('/reports','ReportController@index')->name('reports');
Route::post('/reports/create','ReportController@makeReport')->name('makeReport');
Route::get('reports/{string}','ReportController@showReports');


/* --------------------------------------------------------------------------------------------- */
/* ----------------------------- footer options page controllers ------------------------------- */
/* --------------------------------------------------------------------------------------------- */
Route::get('/about','AboutController@index')->name('about');			//Displays the contact page
Route::get('/releases','ReleaseController@index')->name('release');     //Displays the releases page

Route::get('/support','SupportController@index')->name('support');				// Displays the Report Page
Route::post('/support','SupportController@process');			// Creates the Defect / bug in the Database

/* ----------------------------------------------------------------------------------------- */
/* ------------------------------- Finders page controller --------------------------------- */
/* ----------------------------------------------------------------------------------------- */
Route::get('/finders','Finders\FindersController@index')->name('finders');			// Finders main page

Route::get('/finders/player','Finders\PlayerFinderController@player')->name('findPlayer');		    // Displays the different type of finders
Route::post('/finders/player','Finders\PlayerFinderController@processPlayer');		// Displays the different type of finders
Route::get('/finders/player/{name}/{id?}','Finders\PlayerFinderController@player');		    // Displays the different type of finders

Route::get('/finders/alliance','Finders\AllianceFinderController@alliance')->name('findAlliance');		// Displays the different type of finders
Route::post('/finders/alliance','Finders\AllianceFinderController@processAlliance');	// Displays the different type of finders
Route::get('/finders/alliance/{name}/{id?}','Finders\AllianceFinderController@alliance');	// Displays the different type of finders

Route::get('/finders/inactive','Finders\InactiveFinderController@inactive')->name('findInactive');		// Displays the different type of finders
Route::post('/finders/inactive','Finders\InactiveFinderController@processInactive');		// Displays the result of the inactive finders

Route::get('/finders/natar','Finders\NatarFinderController@natar')->name('findNatar');		        // Displays the different type of finders
Route::post('/finders/natar','Finders\NatarFinderController@processNatar');		// Displays the result of the Natar finders

Route::get('/finders/neighbour','Finders\NeighbourFinderController@neighbour')->name('findNeighbour');		// Displays the different type of finders
Route::post('/finders/neighbour','Finders\NeighbourFinderController@processNeighbour');		// Displays the result of the neighbour finders

/* ----------------------------------------------------------------------------------------- */
/* ------------------------------- Calculators page controller --------------------------------- */
/* ----------------------------------------------------------------------------------------- */
Route::get('/calculators','Calculators\CalculatorController@overview')->name('calculators'); // Displays the Calculators overview page

/* ------------------------------- wheat scout page controller --------------------------------- */
Route::get('/calculators/wheatscout','Calculators\WheatScoutController@display')->name('wheatScout');   //Displays wheat scout menu page
Route::post('/calculators/wheatscout','Calculators\WheatScoutController@calculate');                    //Calculates and Displays wheat scout results

/* ------------------------------- Cropper page controller --------------------------------- */
Route::get('/calculators/cropper','Calculators\CalculatorController@cropper')->name('cropper');     //Displays the cropper development calculator
Route::get('/cropper',function(){
    return redirect('/calculators/cropper');                    
});                                                                //redirects the page to the cropper page in calculators menu

/* ------------------------------------------------------------- */
/* ---------------- Servers page controllers ------------------- */
/* ------------------------------------------------------------- */
Route::get('/servers','ServersController@index')->name('server');
Route::post('/servers','ServersController@process');