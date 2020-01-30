<?php
/* 
 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */

Route::group(['middleware' => ['web'],'prefix' => 'agent','namespace' => 'Agent\\Http\\Controllers'], function () {

    Route::get('login', 'IndexController@index'); 
    
    Route::post('auth', 'IndexController@auth'); 

    Route::any('register', 'IndexController@register');

    Route::post('/updatepassword', 'DashboardController@updatepassword');

    Route::post('/updateprofile', 'DashboardController@updateprofile');
    
    Route::get('/', 'DashboardController@index');

    Route::any('/dashboard', 'DashboardController@dashboard');

    Route::any('/payment-request', 'DashboardController@paymentrequest');

    Route::any('/allbookings', 'DashboardController@allbookings');

    Route::any('/bookings/viewdetails/{bookingid}/{userid}', 'DashboardController@viewdetails');

    Route::any('/bookings/requestchange/{bookingid}', 'DashboardController@requestchange');

    Route::get('flight/ticket/{bookingid}/{userid}','DashboardController@ticket');

    Route::get('bookings/invoice/{bookingid}/{userid}','DashboardController@invoice');

    Route::any('mailticket/{bookingid}','DashboardController@mailticket');

    Route::get('/downloadPDF/{bookingid}/{userid}','DashboardController@downloadPDF');
    
    Route::any('/all-transcation','DashboardController@fetchAllTransation');

    Route::get('/dashboard/exportExcel','DashboardController@exportExcel');

    Route::any('/make-payment','UsersController@paidCreditAmount');
});


Route::group(['middleware' => ['web'],'prefix' => 'distributor','namespace' => 'Agent\\Http\\Controllers'], function () {

    Route::get('login', 'IndexController@index'); 
    
    Route::post('auth', 'IndexController@auth'); 

    Route::any('register', 'IndexController@register');

    Route::post('/updatepassword', 'DashboardController@updatepassword');

    Route::post('/updateprofile', 'DashboardController@updateprofile');
    
    Route::get('/', 'DashboardController@index');

    Route::any('/dashboard', 'DashboardController@dashboard');

    Route::any('/payment-request', 'DashboardController@paymentrequest');

    Route::any('/manage-agents', 'UsersController@index');

    Route::get('/create-agent','UsersController@addAgent');

    Route::any('/submit-agent-data','UsersController@submitAgentDetail');

    Route::any('/submit-agent-data/{id}','UsersController@submitAgentDetail');

    Route::any('/edit-agent-detail/{id}','UsersController@editAgentDetail');

    Route::any('/delete-agent-detail/{id}','UsersController@deleteAgent');
    
    Route::any('/wallet-transaction','UsersController@wallettransaction');

    Route::any('/all-transcation','DashboardController@fetchAllTransation');

    Route::get('/wallet-transaction-histroy','UsersController@walletTransactionHistory');

    Route::any('/allbookings', 'DashboardController@allbookings');

    Route::any('/bookings/viewdetails/{bookingid}/{userid}', 'DashboardController@viewdetails');
    
    Route::get('flight/ticket/{bookingid}/{userid}','DashboardController@ticket');

    Route::get('bookings/invoice/{bookingid}/{userid}','DashboardController@invoice');

    Route::get('/downloadPDF/{bookingid}/{userid}','DashboardController@downloadPDF');

    Route::get('/dashboard/exportExcel','DashboardController@exportExcel');

    Route::any('/credit/request','DashboardController@creditNotifation');

    Route::any('/cancel/credit/request/{id}','DashboardController@CancelRequest');
});






