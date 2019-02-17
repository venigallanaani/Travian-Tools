<?php

/* ------------------------------- Reports page controllers -------------------- */
Route::get('/','ReportController@index')->name('reports');
Route::get('/reports','ReportController@index')->name('reports');
Route::post('/reports/create','ReportController@makeReport');
Route::get('reports/{string}','ReportController@showReports');

/* ----------------------------- footer options page controllers ------------------------------- */
Route::get('/about','AboutController@index')->name('about');			//Displays the contact page
Route::get('/releases','ReleaseController@index')->name('release');     //Displays the releases page

Route::get('/support','SupportController@index');				// Displays the Report Page
Route::post('/support','SupportController@process');			// Creates the Defect / bug in the Database