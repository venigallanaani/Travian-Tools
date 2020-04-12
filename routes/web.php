<?php

Auth::routes();

$this->get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/test','TestController@show');
Route::post('/test','TestController@process');

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
Route::get('/finders/inactive/{x}/{y}/{pop}','Finders\InactiveFinderController@inactive');    // Displays the different type of finders

Route::get('/finders/natar','Finders\NatarFinderController@natar')->name('findNatar');		        // Displays the different type of finders
Route::post('/finders/natar','Finders\NatarFinderController@processNatar');		// Displays the result of the Natar finders
Route::get('/finders/natar/{x}/{y}/{pop}','Finders\NatarFinderController@natar');

Route::get('/finders/neighbour','Finders\NeighbourFinderController@neighbour')->name('findNeighbour');		// Displays the different type of finders
Route::post('/finders/neighbour','Finders\NeighbourFinderController@processNeighbour');		// Displays the result of the neighbour finders
Route::get('/finders/neighbour/{x}/{y}/{dist}/{pop}/{natar}','Finders\NeighbourFinderController@neighbour');

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
/* ------------------------------- Raid troops calculator ------------------------------*/
Route::get('/calculators/raid','Calculators\RaidCalculateController@display')->name('calcRaid');      // Calculates the troops needed to complete raid
Route::post('/calculators/raid','Calculators\RaidCalculateController@calculateRaid');  //Displays result for raid troops

/*----------------------------------------------------------------------------------*/
/* -------------------------- Controller for Account Page -------------------------- */
/*----------------------------------------------------------------------------------*/
Route::get('/account','Account\AccountController@overview')->name('account');			// Account main page
Route::post('/account/find','Account\AccountController@findAccount');
Route::post('/account/add','Account\AccountController@addAccount');

Route::get('/account/delete','Account\AccountController@showDelete')->name('accountDelete');
Route::post('/account/delete','Account\AccountController@deleteAccount');

/* ------------------ Account Villages page --------------------------------*/
Route::get('/account/villages','Account\VillagesController@villagesOverview')->name('accountVillages');
Route::post('/account/villages','Account\VillagesController@updateVillages');

/* ------------------ Account Hero page --------------------------------*/
Route::get('/account/hero','Account\HeroController@heroOverview')->name('accountHero');
Route::post('/account/hero','Account\HeroController@processHero');

/* ------------------ Account Troops page --------------------------------*/
Route::get('/account/troops','Account\TroopsController@troopsOverview')->name('accountTroops');
Route::post('/account/troops/parse','Account\TroopsController@processTroops');
Route::post('/account/troops/update','Account\TroopsController@updateTroops');

/* ------------------ Account Troops Plan page --------------------------------*/
Route::get('/account/plan','Account\PlanController@plansOverview')->name('accountPlan');
Route::post('/account/plan/create','Account\PlanController@createPlan');
Route::post('/account/plan/update','Account\PlanController@updatePlan');
Route::post('/account/plan/delete','Account\PlanController@deletePlan');

/* ------------------------ Account Support page --------------------------------- */
Route::get('/account/support','Account\SupportController@overview')->name('accountSupport');
Route::post('/account/sitter/update', 'Account\SupportController@updateSitters')->name('accountSitter');
Route::post('/account/dual/update', 'Account\SupportController@updateDuals')->name('accountDual');

/* ------------------ Account Alliance page --------------------------------*/
Route::get('/account/alliance','Account\AllianceController@allianceOverview')->name('accountAlliance');


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












/*-----------------------------------------------------------------------------------------------------------------------------*/
/* -------------------------------------------------- Plus Page Routes ------------------------------------------------------- */
/*-----------------------------------------------------------------------------------------------------------------------------*/
Route::get('/plus','Plus\PlusController@index')->name('plus');					// Plus Menu main page

/*-----------------------------------------------   Plus overview routes --------------------------------------------------*/
Route::get('/plus/members','Plus\PlusController@members');                  // Plus members list
Route::get('/plus/member/{id}','Plus\PlusController@member');               // Plus member details 

Route::get('/plus/rankings','Plus\PlusController@rankings');


/* --------------------- Join Plus Group -------------------------- */
Route::get('/plus/join/{link}','Plus\Leader\LeaderController@joinPlusGroup');
Route::post('/plus/join','Plus\Leader\SubscriptionController@refreshLink');

Route::get('/plus/leave','Plus\Leader\LeaderController@showLeaveGroup')->name('plusLeave');
Route::post('/plus/leave','Plus\Leader\LeaderController@leavePlusGroup');


/* ---------------------------------------------- Controller for Plus leader routes -------------------------------------- */
Route::get('/leader/access','Plus\Leader\LeaderController@access');
Route::post('/leader/access/add','Plus\Leader\LeaderController@addAccess');
Route::get('/leader/access/update/{id}/{role}','Plus\Leader\LeaderController@updateAccess');

Route::get('/leader/rankings','Plus\PlusController@tdbRoute');

Route::get('/leader/subscription','Plus\Leader\SubscriptionController@subscriptions');
Route::post('/leader/subscription/message','Plus\Leader\SubscriptionController@messageUpdate');
Route::post('/leader/subscription/options','Plus\Leader\SubscriptionController@optionsUpdate');

/* ----------------------- Discord Settings ---------------------------------------- */
Route::get('/leader/discord','Plus\Leader\NotificationController@showDiscord');
Route::post('/leader/discord','Plus\Leader\NotificationController@updateDiscord');

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

/* -------------------------------------------- Plus Scout Routes ---------------------------------------------------- */

Route::get('/plus/reports','Plus\Reports\ReportsController@showPlusReports');
Route::post('/plus/reports/add','Plus\Reports\ReportsController@addPlusReports');

Route::get('/plus/ldrrpts','Plus\Reports\ReportsController@showLeaderReports');
Route::get('/plus/ldrrpts/delete/{id}','Plus\Reports\ReportsController@deleteLeaderReports');

Route::get('/plus/reports/hammers','Plus\Reports\ReportsController@showEnemyHammers');
Route::post('/plus/reports/hammers/add','Plus\Reports\ReportsController@addEnemyHammer');
Route::get('/plus/reports/hammers/{action}/{id}/{value?}','Plus\Reports\ReportsController@processEnemyHammer');

Route::get('/plus/reports/scouts','Plus\PlusController@tdbRoute');

/* -------------------------------------------- Plus Defense Routes ---------------------------------------------------- */

/* -------------------- Plus member incoming Options -----------------------*/
Route::get('/plus/incoming','Plus\Defense\Incoming\IncomingController@enterIncoming')->name('incoming');
Route::post('/plus/incoming','Plus\Defense\Incoming\IncomingController@processIncoming');
Route::post('/plus/incoming/update','Plus\Defense\Incoming\IncomingController@updateIncoming');

/* -------------------- Plus Leader incoming Options -----------------------*/
Route::get('/defense/incomings','Plus\Defense\Incoming\LeaderIncomingController@LeaderIncomings');
Route::get('/defense/incomings/list','Plus\Defense\Incoming\LeaderIncomingController@LeaderIncomingsList');

Route::post('/defense/incomings/update/comments','Plus\Defense\Incoming\LeaderIncomingController@updateWaveNotes');
Route::get('/defense/incomings/update/{action}/{id}/{value}','Plus\Defense\Incoming\LeaderIncomingController@updateWaveDetails');

Route::post('/defense/incomings/cfd','Plus\Defense\Incoming\LeaderIncomingController@createCFD');
Route::get('/defense/attacker/{id}','Plus\Defense\Incoming\LeaderIncomingController@showAttacker');


/* --------------- Plus group member CFD routes  --------------- */
Route::get('/plus/defense','Plus\Defense\CFD\CFDController@defenseTaskList');
Route::get('/plus/defense/{id}','Plus\Defense\CFD\CFDController@defenseTask');
Route::post('/plus/defense/{id}','Plus\Defense\CFD\CFDController@updateDefenseTask');

/* --------------- Plus leader CFD options routes  --------------- */
Route::get('/defense/cfd','Plus\Defense\CFD\LeaderCFDController@CFDList');
Route::get('/defense/cfd/{id}','Plus\Defense\CFD\LeaderCFDController@CFDDetail');
Route::get('/defense/cfd/troops/{id}/{uid}','Plus\Defense\CFD\LeaderCFDController@CFDTroops');
Route::get('/defense/cfd/travel/{id}','Plus\Defense\CFD\LeaderCFDController@CFDTravel');
Route::post('/defense/cfd/create','Plus\Defense\CFD\LeaderCFDController@createCFD');
Route::post('/defense/cfd/update','Plus\Defense\CFD\LeaderCFDController@processCFD');


/* -------------------- Plus leader Search Defense -----------------------*/
Route::get('/defense/search','Plus\Defense\Search\DefenseController@show');
Route::post('/defense/search','Plus\Defense\Search\DefenseController@process');




/* ---------------------------------------- Plus Offense Routes ------------------------------------------------- */

/* -------------------- Plus member Offense Options -----------------------*/
Route::get('/plus/offense','Plus\Offense\OffenseController@offenseTaskList');
Route::post('/plus/offense/update','Plus\Offense\OffenseController@updateOffenseTask');

/* -------------------- Plus Leader Offense Options -----------------------*/
Route::get('/offense/status','Plus\Offense\LeaderOffenseController@offensePlanList');
Route::post('/offense/create','Plus\Offense\LeaderOffenseController@createOffensePlan');

Route::get('/offense/status/{id}','Plus\Offense\LeaderOffenseController@displayOffensePlan');
Route::post('/offense/status/update','Plus\Offense\LeaderOffenseController@updateOffensePlan');

Route::get('/offense/troops','Plus\Offense\LeaderSearchController@troopsList');
Route::get('/offense/search','Plus\Offense\LeaderSearchController@show');
Route::post('/offense/search','Plus\Offense\LeaderSearchController@search');

/* ----------------------- Plus Leader Offense make and edit plan ------------------------ */
Route::get('/offense/plan/edit/{id}','Plus\Offense\OpsMakerController@showPlanLayout');
/* ----------------------------------- D-D Version --------------------------------- */
Route::post('/offense/plan/additem','Plus\Offense\OpsMakerController@addOpsItem');
Route::get('/offense/plan/delitem/{plan}/{type}/{id}','Plus\Offense\OpsMakerController@delOpsItem');


/* ----------------------------------- Coords Version ------------------------------- */
//Route::get('/offense/plan/edit/{id}','Plus\Offense\OffensePlanController@showPlanLayout');
//Route::post('/offense/plan/update','Plus\Offense\OffensePlanController@updatePlan');
//Route::post('/offense/plan/add','Plus\Offense\OffensePlanController@addWave');
//Route::get('/offense/plan/add/{wave}','Plus\Offense\OffensePlanController@addWave');
//Route::get('/offense/plan/delete/{id}','Plus\Offense\OffensePlanController@deleteWave');

/* ----------------------- Plus Leader Offense archive plan options ------------------------ */
Route::get('/offense/archive','Plus\Offense\offenseArchiveController@archiveList');
Route::get('/offense/archive/{id}','Plus\Offense\offenseArchiveController@displayArchivePlan');
Route::post('/offense/archive/update','Plus\Offense\offenseArchiveController@updateArchivePlan');



/* ---------------------------------------- Plus Offense Routes ------------------------------------------------- */

/* ---------------------- Plus member Artifact Options ------------------------------- */


/* ------------------------------- Plus leader Artifact Options -------------------------------- */
//Route::get('/artifacts','Plus\Artifacts\artifactLeaderController@Overview')->name('ldrArt');
Route::get('/artifacts','Plus\PlusController@tdbRoute')->name('ldrArt');
//Route::get('/artifacts/schedule','Plus\Artifacts\artifactLeaderController@schedule');
Route::get('/artifacts/schedule','Plus\PlusController@tdbRoute');


Route::get('/artifacts/hammers','Plus\Artifacts\artifactCaptureController@hammerDisplay');
Route::post('/artifacts/hammers','Plus\Artifacts\artifactCaptureController@hammerResult');

Route::get('/artifacts/capture','Plus\Artifacts\artifactCaptureController@captureDisplay');
Route::post('/artifacts/capture','Plus\Artifacts\artifactCaptureController@captureResult');



