<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Route::group(['middleware' => ['web'],'namespace' => 'Admin\\Http\\Controllers'], function () {
  Route::get('/loginMeADmin', 'IndexController@index'); 
});

Route::group(['middleware' => ['web'],'prefix' => 'admin','namespace' => 'Admin\\Http\\Controllers'], function () {

   
    
    Route::post('auth', 'IndexController@auth'); 

    //logout
    Route::any('logout', 'IndexController@logout');

  

    Route::get('dashboard','DashboardController@index');
    Route::any('profile', 'DashboardController@profile');
  Route::group( ['middleware' => ['RoleAccess']], function () {
   
  
    Route::get('settings', 'DashboardController@settings');
    

    Route::any('service-charge', 'DashboardController@servicecharge');

    Route::any('wallet-transactions', 'DashboardController@wallettransactions');

    Route::any('agent/suggest','DashboardController@agentSearch');

    Route::any('invoice/{id}', 'DashboardController@invoice');

    Route::any('bankdetail', 'DashboardController@bankdetail');

    Route::any('credit-requests', 'CreditRequestController@index');
    
    Route::any('credit-requests/update-status/{id}/{statusid}', 'CreditRequestController@updatestatus');
    Route::any('credit-requests/topup/{userid}/{id}', 'CreditRequestController@topup');

    Route ::any('update-billed-status/{id}','DashboardController@UpdatedBilledStatus');
   
    Route::get('made-payment-detail/{transid}','DashboardController@transcationDetail'); // paid by agent deta
    //lcc
    Route::any('lcc/{service}', 'DashboardController@managelcc');
	
    Route::any('airlines', 'AirlinesController@index');
    Route::any('airlines/create', 'AirlinesController@create');
    Route::any('airlines/update/{id}', 'AirlinesController@update');
    Route::get('airlines/delete/{id}', 'AirlinesController@delete');
    Route::get('airlines/update-status/{id}/{statusid}', 'AirlinesController@updatestatus');

  //USERS
  Route::get('users', 'UsersController@index');
  Route::any('users/add', 'UsersController@addusers');
  Route::any('users/editusers/{userid}', 'UsersController@edituser');
  Route::get('users/deleteusers/{userid}', 'UsersController@deleteusers');
  Route::get('users/updatestatus/{userid}/{statusid}', 'UsersController@updatestatus');


  //Packages
  Route::get('packages', 'PackagesController@index');
  Route::any('packages/create', 'PackagesController@create');
  Route::any('packages/update/{id}', 'PackagesController@update');
  Route::get('packages/delete/{id}', 'PackagesController@delete');
  Route::get('packages/updatestatus/{id}/{statusid}', 'PackagesController@updatestatus');
  //Packages
  Route::any('package-detail/create/{id}', 'PackageDetailController@create');
  Route::any('package-detail/update/{id}', 'PackageDetailController@update');
  Route::get('package-detail/delete/{id}', 'PackageDetailController@delete');
  Route::get('package-detail/updatestatus/{id}/{statusid}', 'PackageDetailController@updatestatus');

  //AGENTS
  Route::get('agents', 'AgentsController@index');
  Route::any('agents/add', 'AgentsController@addagent');
  Route::any('agents/editagent/{userid}', 'AgentsController@edituser');
  Route::get('agents/deleteagents/{userid}', 'AgentsController@deleteusers');
  Route::get('agents/deletedistributoragent/{userid}/{childid}', 'AgentsController@deletedistributoragent');
  Route::get('agents/updatestatus/{userid}/{statusid}', 'AgentsController@updatestatus');
  Route::post('/updateagentpassword', 'AgentsController@updateagentpassword');#

  Route::any('agents/distributor-agents/{userid}', 'AgentsController@distributoragents');
  Route::any('agents/package-detail/{id}', 'AgentsController@agentpackage');

  Route::get('agent/transactions/{id}','AgentsController@UserAllTransaction');
   
  Route::post('verify-payment','AgentsController@verifyPayment');

  Route::get('payment-receive','AgentsController@fetchallPaymentdetail');
  
  //SERVICES
  Route::get('services', 'ServicesController@index');
  Route::any('services/add', 'ServicesController@addservice');
  Route::any('services/editservices/{serviceid}', 'ServicesController@editservices');
  Route::get('services/deleteservices/{serviceid}', 'ServicesController@deleteservices');
  Route::get('services/updatestatus/{serviceid}/{statusid}', 'ServicesController@updatestatus');


  //CMS

  Route::get('testimonials', 'CmsController@testimonials');
  Route::any('testimonials/addtestimonial', 'CmsController@addtestimonial');
  Route::any('testimonials/edittestimonials/{testimonialid}', 'CmsController@edittestimonial');
  Route::any('testimonials/deletetestimonials/{testimonialid}', 'CmsController@deletetestimonials');

  Route::any('banners', 'CmsController@banneredit');
  
  Route::any('welcomedata', 'CmsController@editwelcomedata');

  Route::any('homesliders', 'CmsController@homesliders');
  Route::any('homesliders/addhomeslider', 'CmsController@addhomeslider');
  Route::any('homesliders/edithomeslider/{homesliderid}', 'CmsController@edithomeslider');
  Route::any('homesliders/deletehomeslider/{homesliderid}', 'CmsController@deletehomeslider');

  Route::any('features', 'CmsController@features');
  Route::any('featuress/addfeatures', 'CmsController@addfeatures');
  Route::any('featuress/editfeatures/{featureid}', 'CmsController@editfeature');
  Route::any('features/deletefeature/{featureid}', 'CmsController@deletefeature');


  //MANAGE SITE DETAILS
 
  Route::any('siteinfo', 'SitedetailController@siteinfo');
  Route::get('sitetextualpages', 'TextualpagesController@index');
  Route::any('sitetextualpages/add', 'TextualpagesController@addtextualpage');
  Route::any('sitetextualpages/edittextualpage/{textualpageid}', 'TextualpagesController@edittextualpage');
  Route::any('sitetextualpages/deletetextualpage/{textualpageid}', 'TextualpagesController@deletetextualpage');
  Route::any('sitetextualpages/updatestatus/{textualpageid}/{statusid}', 'TextualpagesController@updatestatus');

    
  // MANAGE SUB ADMIN
  Route::get('subadmin/add', 'SubadminController@addSubAdminDetail');
  Route::post('submit-subadmin-detail', 'SubadminController@submitDetail');
  Route::post('submit-subadmin-detail/{userid}', 'SubadminController@submitDetail');
  Route::get('subadmin', 'SubadminController@fetchall');
  Route::get('subadmin/editsubadmin/{userid}', 'SubadminController@editsubadmin');
  Route::get('subadmin/delete/{userid}', 'SubadminController@deletesubadmin');
  Route::get('subadmin/updatestatus/{userid}/{statusid}', 'SubadminController@updatestatus');

  // MANAGE BOOKINGS
  Route::any('view_bookings', 'BookingsController@index');
  Route::get('booking/viewdetails/{userid}', 'BookingsController@viewdetails');
  Route::get('booking/updateassignee/{userid}', 'BookingsController@updateassignee');
  Route::get('booking/editdetail/{userid}','BookingsController@editBookingDetail');
  //MANAGE BOOKING REQUEST CHANGE
  Route::any('booking_request_change', 'RequestchangebookingController@index');
  Route::any('booking/viewticket/{bookingid}','BookingsController@viewticket');
  Route::any('booking/downloadPDF/{bookingid}','BookingsController@downloadPDF');
  Route::any('booking/mailticket/{bookingid}','BookingsController@mailticket');
  Route::any('booking/cancel/{bookingid}','BookingsController@cancel');
  
});

  // MANGE Role and SIDEBAR 
  Route::get('access/permission','AccessPermissionController@giveAccess');
  Route::get('access/permission/{id}','AccessPermissionController@giveAccess');
  Route::post('assign/permission/{id}','AccessPermissionController@assignPermission');
  Route::any('role/create','RoleController@createRole');
  Route::any('role/edit/{id}','RoleController@createRole');

  Route::any('transfermoney','AgentsController@modifyTransaction');
});





