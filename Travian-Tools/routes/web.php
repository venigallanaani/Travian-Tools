<?php

Auth::routes();

$this->get('logout', 'Auth\LoginController@logout')->name('logout');

/*----------------------------------------------------------------------------------*/
/* ----------------------------------- Home page ----------------------------------- */
/*----------------------------------------------------------------------------------*/
Route::get('/', 'HomeController@index')->name('home');					// Displays home page on login
Route::get('/home', 'HomeController@index')->name('home');				// Displays home page on selection


/*----------------------------------------------------------------------------------*/
/* --------------------------------- Finders page ---------------------------------- */
/*----------------------------------------------------------------------------------*/
Route::get('/finder','Finders\FindersController@index')->name('finder');			// Finders main page

Route::get('/finder/player','Finders\PlayerFinderController@player');		    // Displays the different type of finders
Route::post('/finder/player','Finders\PlayerFinderController@processPlayer');		// Displays the different type of finders
Route::get('/finder/player/{name}/{id?}','Finders\PlayerFinderController@player');		    // Displays the different type of finders

Route::get('/finder/alliance','Finders\AllianceFinderController@alliance');		// Displays the different type of finders
Route::post('/finder/alliance','Finders\AllianceFinderController@processAlliance');	// Displays the different type of finders
Route::get('/finder/alliance/{name}/{id?}','Finders\AllianceFinderController@alliance');	// Displays the different type of finders

Route::get('/finder/inactive','Finders\InactiveFinderController@inactive');		// Displays the different type of finders
Route::post('/finder/inactive','Finders\InactiveFinderController@processInactive');		// Displays the result of the inactive finders

Route::get('/finder/natar','Finders\NatarFinderController@natar');		        // Displays the different type of finders
Route::post('/finder/natar','Finders\NatarFinderController@processNatar');		// Displays the result of the Natar finders

Route::get('/finder/neighbour','Finders\NeighbourFinderController@neighbour');		// Displays the different type of finders
Route::post('/finder/neighbour','Finders\NeighbourFinderController@processNeighbour');		// Displays the result of the neighbour finders


/*----------------------------------------------------------------------------------*/
/* -------------------------- Controller for Account Page -------------------------- */
/*----------------------------------------------------------------------------------*/
Route::get('/account','Account\AccountController@overview')->name('account');			// Account main page
Route::post('/account/add','Account\AccountController@addAccount');

Route::get('/account/troops','Account\TroopsController@troopsOverview');
Route::post('/account/troops/update','Account\TroopsController@processTroops');

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

/*-------------------------- Plus overview routes ----------------------------*/
Route::get('/plus/members','Plus\PlusController@members');
Route::get('/plus/member/{id}','Plus\PlusController@member');

/* ------------------ Plus player display of rankings ------------------------ */
Route::get('/plus/rankings','Plus\PlusController@rankings');

/* --------------- Controller for Plus leader routes --------------- */
Route::get('/leader/access','Plus\Leader\LeaderController@access');	
Route::post('/leader/access/add','Plus\Leader\LeaderController@addAccess');
Route::get('/leader/access/update/{id}/{role}','Plus\Leader\LeaderController@updateAccess');

Route::get('/leader/rankings','Plus\Leader\LeaderController@showRankings');	

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

/* -------------------- Plus member incoming Options -----------------------*/
Route::get('/plus/incoming','Plus\Defense\Incoming\IncomingController@enterIncoming');
Route::post('/plus/incoming','Plus\Defense\Incoming\IncomingController@processIncoming');
Route::post('/plus/incoming/update','Plus\Defense\Incoming\IncomingController@updateIncoming');

/* -------------------- Plus Leader incoming Options -----------------------*/
Route::get('/defense/incoming','Plus\Defense\Incoming\LeaderIncomingController@IncomingList');

/* -------------------- Plus member Offense Options -----------------------*/
Route::get('/plus/offense','Plus\Offense\OffenseController@offenseTaskList');
Route::post('/plus/offense','Plus\Offense\OffenseController@updateOffenseTask');

/* -------------------- Plus Leader Offense Options -----------------------*/
Route::get('/offense/status','Plus\Offense\LeaderOffenseController@offensePlanList');
Route::post('/offense/create','Plus\Offense\LeaderOffenseController@createOffensePlan');

Route::get('/offense/status/{id}','Plus\Offense\LeaderOffenseController@displayOffensePlan');
Route::post('/offense/status/update','Plus\Offense\LeaderOffenseController@updateOffensePlan');

Route::get('/offense/troops','Plus\Offense\LeaderOffenseController@troopsList');

/* ----------------------- Plus Leader Offense make and edit plan ------------------------ */
Route::get('/offense/plan/edit/{id}','Plus\Offense\MakeOffensePlanController@showPlanLayout');
Route::post('/offense/plan/update','Plus\Offense\MakeOffensePlanController@updatePlan');

/* ----------------------- Plus Leader Offense archive plan options ------------------------ */
Route::get('/offense/archive','Plus\Offense\offenseArchiveController@archiveList');
Route::get('/offense/archive/{id}','Plus\Offense\offenseArchiveController@displayArchivePlan');
Route::post('/offense/archive/update','Plus\Offense\offenseArchiveController@updateArchivePlan');

/* --------------- Controller for the Report Page ----------- */
Route::get('/support','supportController@index');				// Displays the Report Page
Route::post('/support','supportController@process');			// Creates the Defect / bug in the Database

/* ------------------ Profile Controller Page -------------- */
Route::get('/profile','Profile\profileController@overview');
Route::post('/profile/contact','Profile\profileController@updateContact');

Route::get('/profile/servers','Profile\profileController@servers');
Route::post('/profile/servers/load','ServersController@process');


/* --------------- Controller for the Contact Page ------------ */
Route::get('/about','AboutController@index');			//Displays the contact page


/* ---------------- Servers page controllers ------------------- */
Route::get('/servers','ServersController@index')->name('server');
Route::post('/servers','ServersController@process');


