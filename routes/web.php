<?php

/* ------------------------------- Reports page controllers -------------------- */
Route::get('/','ReportController@index')->name('reports');
Route::get('/home','ReportController@index')->name('reports');
Route::get('/reports','ReportController@index')->name('reports');
Route::post('/reports/create','ReportController@makeReport');
Route::get('reports/{string}','ReportController@showReports');

/* ----------------------------- footer options page controllers ------------------------------- */
Route::get('/about','AboutController@index')->name('about');			//Displays the contact page
Route::get('/releases','ReleaseController@index')->name('release');     //Displays the releases page

Route::get('/support','SupportController@index');				// Displays the Report Page
Route::post('/support','SupportController@process');			// Creates the Defect / bug in the Database

/* ----------------------------------------------------------------------------------------- */
/* ------------------------------- Finders page controller --------------------------------- */
/* ----------------------------------------------------------------------------------------- */
Route::get('/finders','Finders\FindersController@index')->name('finders');			// Finders main page

Route::get('/finders/player','Finders\PlayerFinderController@player');		    // Displays the different type of finders
Route::post('/finders/player','Finders\PlayerFinderController@processPlayer');		// Displays the different type of finders
Route::get('/finders/player/{name}/{id?}','Finders\PlayerFinderController@player');		    // Displays the different type of finders

Route::get('/finders/alliance','Finders\AllianceFinderController@alliance');		// Displays the different type of finders
Route::post('/finders/alliance','Finders\AllianceFinderController@processAlliance');	// Displays the different type of finders
Route::get('/finders/alliance/{name}/{id?}','Finders\AllianceFinderController@alliance');	// Displays the different type of finders

Route::get('/finders/inactive','Finders\InactiveFinderController@inactive');		// Displays the different type of finders
Route::post('/finders/inactive','Finders\InactiveFinderController@processInactive');		// Displays the result of the inactive finders

Route::get('/finders/natar','Finders\NatarFinderController@natar');		        // Displays the different type of finders
Route::post('/finders/natar','Finders\NatarFinderController@processNatar');		// Displays the result of the Natar finders

Route::get('/finders/neighbour','Finders\NeighbourFinderController@neighbour');		// Displays the different type of finders
Route::post('/finders/neighbour','Finders\NeighbourFinderController@processNeighbour');		// Displays the result of the neighbour finders


/* ------------------------------- Cropper page controller --------------------------------- */
// Route::get('/calculators','Calculators\CalculatorController@overview')->name('calculators');

// Route::get('/calculators/cropper','Calculators\CropperController@display')->name('cropper');
// Route::post('/calculators/cropper','Calculators\CropperController@process');
// Route::get('/calculators/cropper/{crop}/{cap}/{o1}/{o2}/{o3}/{plus}','Calculators\CropperController@calculate');


/* ------------------------------- Cropper page controller --------------------------------- */

Route::get('/cropper','Calculators\CropperController@display')->name('cropper');
Route::post('/cropper','Calculators\CropperController@process');
Route::get('/cropper/{crop}/{cap}/{o1}/{o2}/{o3}/{plus}','Calculators\CropperController@calculate');


/* ---------------- Servers page controllers ------------------- */
Route::get('/servers','ServersController@index')->name('server');
Route::post('/servers','ServersController@process');