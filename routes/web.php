<?php
Auth::routes();

$this->get('logout', 'Auth\LoginController@logout')->name('logout');

/*----------------------------------------------------------------------------------*/
/* ----------------------------------- Home page ----------------------------------- */
/*----------------------------------------------------------------------------------*/
Route::get('/', 'HomeController@index')->name('home');					// Displays home page on login
Route::get('/home', 'HomeController@index')->name('home');				// Displays home page on selection

/* ------------------------------- Reports page controllers -------------------- */
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
//Route::get('/calculators','Calculators\CalculatorController@overview')->name('calculators');

Route::get('/calculators/cropper','Calculators\CropperController@display')->name('cropper');
Route::post('/calculators/cropper','Calculators\CropperController@process');
Route::get('/calculators/cropper/{crop}/{cap}/{o1}/{o2}/{o3}/{plus}','Calculators\CropperController@calculate');


/* ---------------- Servers page controllers ------------------- */
Route::get('/servers','ServersController@index')->name('server');
Route::post('/servers','ServersController@process');

/*----------------------------------------------------------------------------------*/
/* -------------------------- Controller for Account Page -------------------------- */
/*----------------------------------------------------------------------------------*/
Route::get('/account','Account\AccountController@overview')->name('account');			// Account main page
Route::post('/account/add','Account\AccountController@addAccount');

Route::get('/account/troops','Account\TroopsController@troopsOverview');
Route::post('/account/troops/parse','Account\TroopsController@processTroops');
Route::post('/account/troops/update','Account\TroopsController@updateTroops');

Route::get('/account/hero','Account\HeroController@heroOverview');
Route::post('/account/hero/update','Account\HeroController@processHero');

Route::get('/account/alliance','Account\AllianceController@allianceOverview');

Route::get('/account/support','Account\SupportController@overview');
Route::post('/account/sitter/update', 'Account\SupportController@updateSitters');
Route::post('/account/dual/update', 'Account\SupportController@updateDuals');

/*----------------------------------------------------------------------------------*/
/* ----------------------- Plus Page Routes --------------------------- */
/*----------------------------------------------------------------------------------*/
Route::get('/plus','Plus\PlusController@index')->name('plus');					// Plus Menu main page

/* --------------------- Join Plus Group -------------------------- */
Route::get('/plus/join/{link}','Plus\Leader\LeaderController@joinPlusGroup');
Route::post('/plus/join','Plus\Leader\SubscriptionController@refreshLink');
Route::post('/plus/leave','Plus\Leader\LeaderController@leavePlusGroup');

/*-------------------------- Plus overview routes ----------------------------*/
Route::get('/plus/members','Plus\PlusController@members');
Route::get('/plus/member/{id}','Plus\PlusController@member');

/* ------------------ Plus player display of rankings ------------------------ */
Route::get('/plus/rankings','Plus\PlusController@rankings');

/* --------------- Controller for Plus leader routes --------------- */
Route::get('/leader/access','Plus\Leader\LeaderController@access');
Route::get('/leader/access/update/{id}/{role}','Plus\Leader\LeaderController@updateAccess');

Route::get('/leader/rankings','Plus\Leader\LeaderController@showRankings');

Route::get('/leader/subscription','Plus\Leader\SubscriptionController@subscriptions');
Route::post('/leader/subscription/message','Plus\Leader\SubscriptionController@messageUpdate');

/* --------------- Plus Member Resource routes  --------------- */
Route::get('/plus/resource','Plus\Resources\ResourceController@showTaskList');
Route::get('/plus/resource/{id}','Plus\Resources\ResourceController@showTask');
Route::post('/plus/resource/{id}','Plus\Resources\ResourceController@updateTask');

/* --------------- Plus Leader Resource routes  --------------- */
Route::get('/resource','Plus\Resources\LeaderResourceController@resourceTaskList');
Route::get('/resource/{id}','Plus\Resources\LeaderResourceController@resourceTask');
Route::post('/resource/create','Plus\Resources\LeaderResourceController@createResourceTask');
Route::post('/resource/update','Plus\Resources\LeaderResourceController@processResourceTask');

/* --------------- Plus group member CFD routes  --------------- */
Route::get('/plus/defense','Plus\Defense\CFD\CFDController@defenseTaskList');
Route::get('/plus/defense/{id}','Plus\Defense\CFD\CFDController@defenseTask');
Route::post('/plus/defense/{id}','Plus\Defense\CFD\CFDController@updateDefenseTask');

/* --------------- Plus leader CFD options routes  --------------- */
Route::get('/defense/cfd','Plus\Defense\CFD\LeaderCFDController@CFDList');
Route::get('/defense/cfd/{id}','Plus\Defense\CFD\LeaderCFDController@CFDDetail');
Route::get('/defense/cfd/troops/{id}/{uid}','Plus\Defense\CFD\LeaderCFDController@CFDTroops');
Route::post('/defense/cfd/create','Plus\Defense\CFD\LeaderCFDController@createCFD');
Route::post('/defense/cfd/update','Plus\Defense\CFD\LeaderCFDController@processCFD');

/* -------------------- Plus Search Defense -----------------------*/
Route::get('/defense/search','Plus\Defense\Search\DefenseController@show');
Route::post('/defense/search','Plus\Defense\Search\DefenseController@process');

/* ------------------ Profile Controller Page -------------- */
Route::get('/profile','Profile\profileController@overview');
Route::post('/profile/contact','Profile\profileController@updateContact');

Route::get('/profile/servers','Profile\profileController@servers');
Route::post('/profile/servers/load','ServersController@process');
