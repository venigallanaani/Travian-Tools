<?php

Auth::routes();

$this->get('logout', 'Auth\LoginController@logout')->name('logout');

/*----------------------------------------------------------------------------------*/
/* ----------------------------------- Home page ----------------------------------- */
/*----------------------------------------------------------------------------------*/
Route::get('/', 'HomeController@index')->name('home');					// Displays home page on login
Route::get('/home', 'HomeController@index')->name('home');				// Displays home page on selection


/* ----------------------------------------------------------------------------- */
/* ------------------------------- Reports page controllers -------------------- */
/* ----------------------------------------------------------------------------- */
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


/*----------------------------------------------------------------------------------*/
/* -------------------------- Controller for Account Page -------------------------- */
/*----------------------------------------------------------------------------------*/
Route::get('/account','Account\AccountController@overview')->name('account');			// Account main page
Route::post('/account/find','Account\AccountController@findAccount');
Route::post('/account/add','Account\AccountController@addAccount');

/* ------------------ Account Troops page --------------------------------*/
Route::get('/account/troops','Account\TroopsController@troopsOverview')->name('accountTroops');
Route::post('/account/troops/parse','Account\TroopsController@processTroops');
Route::post('/account/troops/update','Account\TroopsController@updateTroops');

/* ------------------ Account Hero page --------------------------------*/
Route::get('/account/hero','Account\HeroController@heroOverview')->name('accountHero');
Route::post('/account/hero','Account\HeroController@processHero');

Route::get('/account/alliance','Account\AllianceController@allianceOverview')->name('accountAlliance');

/* ------------------------ Account Support page --------------------------------- */
Route::get('/account/support','Account\SupportController@overview')->name('accountSupport');
Route::post('/account/sitter/update', 'Account\SupportController@updateSitters')->name('accountSitter');
Route::post('/account/dual/update', 'Account\SupportController@updateDuals')->name('accountDual');


/*----------------------------------------------------------------------------------*/
/* ---------------------------- Profile Controller Page --------------------------- */
/*----------------------------------------------------------------------------------*/
Route::get('/profile','Profile\profileController@overview')->name('profile');
Route::post('/profile/contact','Profile\profileController@updateContact')->name('profileContact');

Route::get('/profile/servers','Profile\profileController@servers')->name('profileServers');
Route::post('/profile/servers/load','ServersController@process');




/* ------------------------------------------------------------- */
/* ---------------- Servers page controllers ------------------- */
/* ------------------------------------------------------------- */
Route::get('/servers','ServersController@index')->name('servers');
Route::post('/servers','ServersController@process');












/*----------------------------------------------------------------------------------*/
/* --------------------------------- Plus Page Routes ----------------------------- */
/*----------------------------------------------------------------------------------*/
Route::get('/plus','Plus\PlusController@index')->name('plus');					// Plus Menu main page

/*-----------------------------------------------   Plus overview routes --------------------------------------------------*/
Route::get('/plus/members','Plus\PlusController@members');                  // Plus members list
Route::get('/plus/member/{id}','Plus\PlusController@member');               // Plus member details 


Route::get('/plus/rankings','Plus\PlusController@tdbRoute');
Route::get('/plus/incoming','Plus\PlusController@tdbRoute');
Route::get('/plus/offense','Plus\PlusController@tdbRoute');


/* --------------------- Join Plus Group -------------------------- */
Route::get('/plus/join/{link}','Plus\Leader\LeaderController@joinPlusGroup');
Route::post('/plus/join','Plus\Leader\SubscriptionController@refreshLink');
Route::post('/plus/leave','Plus\Leader\LeaderController@leavePlusGroup');


/* ---------------------------------------------- Controller for Plus leader routes -------------------------------------- */
Route::get('/leader/access','Plus\Leader\LeaderController@access');
Route::post('/leader/access/add','Plus\Leader\LeaderController@addAccess');
Route::get('/leader/access/update/{id}/{role}','Plus\Leader\LeaderController@updateAccess');

//Route::get('/leader/rankings','Plus\Leader\LeaderController@showRankings');
Route::get('/leader/rankings','Plus\PlusController@tdbRoute');

Route::get('/leader/subscription','Plus\Leader\SubscriptionController@subscriptions');
Route::post('/leader/subscription/message','Plus\Leader\SubscriptionController@messageUpdate');

/* -------------------------------------------- Plus Resoruces Routes ---------------------------------------------------- */

/* --------------- Resource Member routes --------------- */
Route::get('/plus/resource','Plus\Resources\ResourceController@showTaskList')->name('plusRes');
Route::get('/plus/resource/{id}','Plus\Resources\ResourceController@showTask');
Route::post('/plus/resource/{id}','Plus\Resources\ResourceController@updateTask');

/* --------------- Resource Leader routes  --------------- */
Route::get('/resource','Plus\Resources\LeaderResourceController@resourceTaskList')->name('plusResLdr');
Route::get('/resource/{id}','Plus\Resources\LeaderResourceController@resourceTask');
Route::post('/resource/create','Plus\Resources\LeaderResourceController@createResourceTask');
Route::post('/resource/update','Plus\Resources\LeaderResourceController@processResourceTask');	

/* -------------------------------------------- Plus Defense Routes ---------------------------------------------------- */

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



