<?php

/* ------------------------------- Reports page controllers -------------------- */
Route::get('/','ReportController@index')->name('reports');
Route::get('/reports','ReportController@index')->name('reports');
Route::post('/reports/create','ReportController@makeReport');
Route::get('reports/{string}','ReportController@showReports');
