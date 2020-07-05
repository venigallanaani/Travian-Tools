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

/* ------------------------------- Merchants Trade Route calculator ------------------------------*/
Route::get('/calculators/trade','Calculators\TradeCalculateController@display')->name('calcTrade');      // Displays the merchant routes calculation
Route::post('/calculators/trade','Calculators\TradeCalculateController@calculateTrade');  //Displays result for merchant routes calculations

/* ------------------------------- Buildings NPC calculator ------------------------------*/
Route::get('/calculators/npc','Calculators\NPCCalculateController@display')->name('calcNPC');      // Displays the merchant routes calculation
Route::post('/calculators/npc','Calculators\NPCCalculateController@calculateNPC');  //Displays result for merchant routes calculations

/*----------------------------------------------------------------------------------*/
/* ------------------------- Controllers for Account Page ------------------------- */
/*----------------------------------------------------------------------------------*/
Route::get('/account','Account\AccountController@overview')->name('account')->middleware('auth');			// Account main page
Route::post('/account/find','Account\AccountController@findAccount')->middleware('auth');
Route::post('/account/add','Account\AccountController@addAccount')->middleware('auth');

Route::get('/account/delete','Account\AccountController@showDelete')->name('accountDelete')->middleware('auth');
Route::post('/account/delete','Account\AccountController@deleteAccount')->middleware('auth');

/* ------------------ Account Villages page --------------------------------*/
Route::get('/account/villages','Account\VillagesController@villagesOverview')->name('accountVillages')->middleware('auth');
Route::post('/account/villages','Account\VillagesController@updateVillages')->middleware('auth');

/* ------------------ Account Hero page --------------------------------*/
Route::get('/account/hero','Account\HeroController@heroOverview')->name('accountHero')->middleware('auth');
Route::post('/account/hero','Account\HeroController@processHero')->middleware('auth');

/* ------------------ Account Troops page --------------------------------*/
Route::get('/account/troops','Account\TroopsController@troopsOverview')->name('accountTroops')->middleware('auth');
Route::post('/account/troops/parse','Account\TroopsController@processTroops')->middleware('auth');
Route::post('/account/troops/update','Account\TroopsController@updateTroops')->middleware('auth');

/* ------------------ Account Troops Plan page --------------------------------*/
Route::get('/account/plan','Account\PlanController@plansOverview')->name('accountPlan')->middleware('auth');
Route::post('/account/plan/create','Account\PlanController@createPlan')->middleware('auth');
Route::post('/account/plan/update','Account\PlanController@updatePlan')->middleware('auth');
Route::post('/account/plan/delete','Account\PlanController@deletePlan')->middleware('auth');

/* ------------------------ Account Support page --------------------------------- */
Route::get('/account/support','Account\SupportController@overview')->name('accountSupport')->middleware('auth');
Route::post('/account/sitter/update', 'Account\SupportController@updateSitters')->name('accountSitter')->middleware('auth');
Route::post('/account/dual/update', 'Account\SupportController@updateDuals')->name('accountDual')->middleware('auth');

/* ------------------ Account Alliance page --------------------------------*/
Route::get('/account/alliance','Account\AllianceController@allianceOverview')->name('accountAlliance')->middleware('auth');

/* ------------------ Account Timings page --------------------------------*/
Route::get('/account/timings','Account\TimingsController@displayTimings')->name('accountTimings')->middleware('auth');
Route::get('/account/timings/update/{day}/{time}','Account\TimingsController@updateTimings')->middleware('auth');
Route::post('/account/timings/update','Account\TimingsController@updateTimezone')->middleware('auth');


/*----------------------------------------------------------------------------------*/
/* ---------------------------- Profile Controller Page --------------------------- */
/*----------------------------------------------------------------------------------*/
Route::get('/profile','Profile\profileController@overview')->name('profile')->middleware('auth');
Route::post('/profile/update','Profile\profileController@updateProfile')->name('profileUpdate')->middleware('auth');

Route::get('/profile/servers','Profile\profileController@servers')->name('profileServers')->middleware('auth');
Route::post('/profile/servers/load','ServersController@process')->middleware('auth');


/* ------------------------------------------------------------- */
/* ---------------- Servers page controllers ------------------- */
/* ------------------------------------------------------------- */
Route::get('/servers','ServersController@index')->name('servers');
Route::post('/servers','ServersController@process');



/*-----------------------------------------------------------------------------------------------------------------------------*/
/* -------------------------------------------------- Plus Page Routes ------------------------------------------------------- */
/*-----------------------------------------------------------------------------------------------------------------------------*/
Route::get('/plus','Plus\PlusController@index')->name('plus')->middleware('auth');					// Plus Menu main page

/*-----------------------------------------------   Plus overview routes --------------------------------------------------*/
Route::get('/plus/members','Plus\PlusController@members')->middleware('auth','plus');                  // Plus members list
Route::get('/plus/member/{id}','Plus\PlusController@member')->middleware('auth','plus');               // Plus member details 
Route::get('/plus/timings/{id}','Plus\PlusController@timings')->middleware('auth','plus');               // Plus member details 

Route::get('/plus/rankings','Plus\PlusController@tdbRoute')->middleware('auth','plus');


/* --------------------- Join Plus Group -------------------------- */
Route::get('/plus/join/{link}','Plus\Leader\LeaderController@joinPlusGroup')->middleware('auth');
Route::post('/plus/join','Plus\Leader\SubscriptionController@refreshLink')->middleware('auth','plus');

Route::get('/plus/leave','Plus\Leader\LeaderController@showLeaveGroup')->name('plusLeave')->middleware('auth','plus');
Route::post('/plus/leave','Plus\Leader\LeaderController@leavePlusGroup')->middleware('auth','plus');


/* ---------------------------------------------- Controller for Plus leader routes -------------------------------------- */
Route::get('/leader/access','Plus\Leader\LeaderController@access')->middleware('auth','plus');
Route::post('/leader/access/add','Plus\Leader\LeaderController@addAccess')->middleware('auth','plus');
Route::get('/leader/access/update/{id}/{role}','Plus\Leader\LeaderController@updateAccess')->middleware('auth','plus');

Route::get('/leader/rankings','Plus\PlusController@tdbRoute')->middleware('auth','plus');

Route::get('/leader/subscription','Plus\Leader\SubscriptionController@subscriptions')->middleware('auth','plus');
Route::post('/leader/subscription/message','Plus\Leader\SubscriptionController@messageUpdate')->middleware('auth','plus');
Route::post('/leader/subscription/options','Plus\Leader\SubscriptionController@optionsUpdate')->middleware('auth','plus');

/* ----------------------- Discord Settings ---------------------------------------- */
Route::get('/leader/discord','Plus\Leader\NotificationController@showDiscord')->middleware('auth','plus');
Route::post('/leader/discord','Plus\Leader\NotificationController@updateDiscord')->middleware('auth','plus');

/* -------------------------------------------- Plus Resoruces Routes ---------------------------------------------------- */

/* --------------- Resource Member routes --------------- */
Route::get('/plus/resource','Plus\Resources\ResourceController@showTaskList')->name('plusRes')->middleware('auth','plus');
Route::get('/plus/resource/{id}','Plus\Resources\ResourceController@showTask')->middleware('auth','plus');
Route::post('/plus/resource/{id}','Plus\Resources\ResourceController@updateTask')->middleware('auth','plus');
/* --------------- Resource Leader routes  --------------- */
Route::get('/resource','Plus\Resources\LeaderResourceController@resourceTaskList')->name('plusResLdr')->middleware('auth','plus');
Route::get('/resource/{id}','Plus\Resources\LeaderResourceController@resourceTask')->middleware('auth','plus');
Route::post('/resource/create','Plus\Resources\LeaderResourceController@createResourceTask')->middleware('auth','plus');
Route::post('/resource/update','Plus\Resources\LeaderResourceController@processResourceTask')->middleware('auth','plus');	

/* -------------------------------------------- Plus Scout Routes ---------------------------------------------------- */

Route::get('/plus/reports','Plus\Reports\ReportsController@showPlusReports')->middleware('auth','plus');
Route::post('/plus/reports/add','Plus\Reports\ReportsController@addPlusReports')->middleware('auth','plus');

Route::get('/plus/ldrrpts','Plus\Reports\ReportsController@showLeaderReports')->middleware('auth','plus');
Route::get('/plus/ldrrpts/delete/{id}','Plus\Reports\ReportsController@deleteLeaderReports')->middleware('auth','plus');

Route::get('/plus/reports/hammers','Plus\Reports\ReportsController@showEnemyHammers')->middleware('auth','plus');
Route::post('/plus/reports/hammers/add','Plus\Reports\ReportsController@addEnemyHammer')->middleware('auth','plus');
Route::get('/plus/reports/hammers/{action}/{id}/{value?}','Plus\Reports\ReportsController@processEnemyHammer')->middleware('auth','plus');

Route::get('/plus/reports/scouts','Plus\PlusController@tdbRoute')->middleware('auth','plus');

/* -------------------------------------------- Plus Defense Routes ---------------------------------------------------- */

/* -------------------- Plus member incoming Options -----------------------*/
Route::get('/plus/incoming','Plus\Defense\Incoming\IncomingController@enterIncoming')->name('incoming')->middleware('auth','plus');
Route::post('/plus/incoming','Plus\Defense\Incoming\IncomingController@processIncoming')->middleware('auth','plus');
Route::post('/plus/incoming/update','Plus\Defense\Incoming\IncomingController@updateIncoming')->middleware('auth','plus');

/* -------------------- Plus Leader incoming Options -----------------------*/
Route::get('/defense/incomings','Plus\Defense\Incoming\LeaderIncomingController@LeaderIncomings')->middleware('auth','plus');
Route::get('/defense/incomings/list','Plus\Defense\Incoming\LeaderIncomingController@LeaderIncomingsList')->middleware('auth','plus');

Route::post('/defense/incomings/update/comments','Plus\Defense\Incoming\LeaderIncomingController@updateWaveNotes')->middleware('auth','plus');
Route::get('/defense/incomings/update/{action}/{id}/{value}','Plus\Defense\Incoming\LeaderIncomingController@updateWaveDetails')->middleware('auth','plus');

Route::post('/defense/incomings/cfd','Plus\Defense\Incoming\LeaderIncomingController@createCFD')->middleware('auth','plus');
Route::get('/defense/attacker/{id}','Plus\Defense\Incoming\LeaderIncomingController@showAttacker')->middleware('auth','plus');


/* --------------- Plus group member CFD routes  --------------- */
Route::get('/plus/defense','Plus\Defense\CFD\CFDController@defenseTaskList')->middleware('auth','plus');
Route::get('/plus/defense/{id}','Plus\Defense\CFD\CFDController@defenseTask')->middleware('auth','plus');
Route::post('/plus/defense/{id}','Plus\Defense\CFD\CFDController@updateDefenseTask')->middleware('auth','plus');

/* --------------- Plus leader CFD options routes  --------------- */
Route::get('/defense/cfd','Plus\Defense\CFD\LeaderCFDController@CFDList')->middleware('auth','plus');
Route::get('/defense/cfd/{id}','Plus\Defense\CFD\LeaderCFDController@CFDDetail')->middleware('auth','plus');
Route::get('/defense/cfd/troops/{id}/{uid}','Plus\Defense\CFD\LeaderCFDController@CFDTroops')->middleware('auth','plus');
Route::get('/defense/cfd/travel/{id}','Plus\Defense\CFD\LeaderCFDController@CFDTravel')->middleware('auth','plus');
Route::post('/defense/cfd/create','Plus\Defense\CFD\LeaderCFDController@createCFD')->middleware('auth','plus');
Route::post('/defense/cfd/update','Plus\Defense\CFD\LeaderCFDController@processCFD')->middleware('auth','plus');


/* -------------------- Plus leader Search Defense -----------------------*/
Route::get('/defense/search','Plus\Defense\Search\SearchDefenseController@show')->middleware('auth','plus');
Route::post('/defense/search','Plus\Defense\Search\SearchDefenseController@process')->middleware('auth','plus');




/* ---------------------------------------- Plus Offense Routes ------------------------------------------------- */

/* -------------------- Plus member Offense Options -----------------------*/
Route::get('/plus/offense','Plus\Offense\OffenseController@offenseTaskList')->middleware('auth','plus');
Route::post('/plus/offense/update','Plus\Offense\OffenseController@updateOffenseTask')->middleware('auth','plus');

/* -------------------- Plus Leader Offense Options -----------------------*/
Route::get('/offense/status','Plus\Offense\LeaderOffenseController@offensePlanList')->middleware('auth','plus');
Route::post('/offense/create','Plus\Offense\LeaderOffenseController@createOffensePlan')->middleware('auth','plus');

Route::get('/offense/status/{id}','Plus\Offense\LeaderOffenseController@displayOffensePlan')->middleware('auth','plus');
Route::post('/offense/status/update','Plus\Offense\LeaderOffenseController@updateOffensePlan')->middleware('auth','plus');

Route::get('/offense/troops','Plus\Offense\LeaderSearchController@hammersList')->middleware('auth','plus');
Route::get('/offense/search','Plus\Offense\LeaderSearchController@searchOffense')->middleware('auth','plus');
Route::post('/offense/search','Plus\Offense\LeaderSearchController@resultOffense')->middleware('auth','plus');

/* ----------------------- Plus Leader Offense make and edit plan ------------------------ */
Route::get('/offense/plan/edit/{id}','Plus\Offense\OpsMakerController@showPlanLayout')->middleware('auth','plus');
/* ----------------------------------- D-D Version --------------------------------- */
/* -- add and delete items - target & attacker -- */
Route::post('/offense/plan/additem','Plus\Offense\OpsMakerController@addOpsItem')->middleware('auth','plus');
Route::get('/offense/plan/delitem/{plan}/{type}/{id}','Plus\Offense\OpsMakerController@delOpsItem')->middleware('auth','plus');
/* -- add and delete waves in the plan -- */
Route::get('/offense/plan/addwave/{plan}/{id}','Plus\Offense\OpsMakerController@addWave')->middleware('auth','plus');
Route::post('/offense/plan/deletewave','Plus\Offense\OpsMakerController@deleteWave')->middleware('auth','plus');
Route::post('/offense/plan/editwave','Plus\Offense\OpsMakerController@editWave')->middleware('auth','plus');

/* ----------------------- Plus Leader Offense archive plan options ------------------------ */
Route::get('/offense/archive','Plus\Offense\offenseArchiveController@archiveList')->middleware('auth','plus');
Route::get('/offense/archive/{id}','Plus\Offense\offenseArchiveController@displayArchivePlan')->middleware('auth','plus');
Route::post('/offense/archive/update','Plus\Offense\offenseArchiveController@updateArchivePlan')->middleware('auth','plus');


/* ---------------------- Plus member Artifact Options ------------------------------- */


/* ------------------------------- Plus leader Artifact Options -------------------------------- */
//Route::get('/artifacts','Plus\Artifacts\artifactLeaderController@Overview')->name('ldrArt')->middleware('auth','plus');
Route::get('/artifacts','Plus\PlusController@tdbRoute')->name('ldrArt')->middleware('auth','plus');
//Route::get('/artifacts/schedule','Plus\Artifacts\artifactLeaderController@schedule')->middleware('auth','plus');
Route::get('/artifacts/schedule','Plus\PlusController@tdbRoute')->middleware('auth','plus');


Route::get('/artifacts/hammers','Plus\Artifacts\artifactCaptureController@hammerDisplay')->middleware('auth','plus');
Route::post('/artifacts/hammers','Plus\Artifacts\artifactCaptureController@hammerResult')->middleware('auth','plus');

Route::get('/artifacts/capture','Plus\Artifacts\artifactCaptureController@captureDisplay')->middleware('auth','plus');
Route::post('/artifacts/capture','Plus\Artifacts\artifactCaptureController@captureResult')->middleware('auth','plus');



