<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('home');
});*/

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
//admin routes
Route::get('/admin', 'IndexController@index')->name('admin');
//agent routes
Route::get('/agent', 'AgentController@index')->name('agent');

Route::any('/ajax/get-state', 'AjaxController@getstatelist');
Route::post('/ajax/get-city', 'AjaxController@getcitylist');
Route::post('/ajax/update-settings-api', 'AjaxController@updatesettings');
Route::post('/ajax/update-lcc', 'AjaxController@updatelcc');

//agent routes
Route::get('/flights', 'FlightsController@index');
Route::post('/updatepassword', 'DashboardController@updatepassword');
Route::post('/updateprofile', 'DashboardController@updateprofile');
Route::get('/dashboard', 'DashboardController@index');
//contactus
Route::any('contactus', 'HomeController@contactus');
Route::get('/flights/get-airport-list-json', 'FlightsController@getAirportListJson');
Route::post('/flights/search', 'FlightsController@search');
Route::any('/book-now', 'FlightsController@booknow');
Route::post('/flights/details', 'FlightsController@details');

Route::any('/flights/submit-booking', 'FlightsController@submitBooking');

Route::post('/flights/set-details', 'FlightsController@setDetails');

Route::post('/flights/submit-booking-details', 'FlightsController@submitBookingDetails');

Route::any('/payment/flight', 'PaymentsController@paymentFlight');

Route::any('/payment/pay-online', 'PaymentsController@payOnline');

Route::any('/ajax/getcomission','FlightsController@getcomission');

Route::any('/payment/checkout-submit', 'PaymentsController@checkoutSubmit');

Route::any('/payment/success', 'PaymentsController@paymentSuccess');

Route::any('/payment/failed', 'PaymentsController@paymentFailed');

Route::get('page/{pageslug}', 'HomeController@pagedetail');

Route::get('api/login', 'ApiController@login');

Route::get('bank/detail','HomeController@bankdetail');
Auth::routes(['verify' => true]);

Route::any('/farequote','FlightsController@farequote');

// Hotel Routes
Route::any('hotels','HotelsController@index');
Route::any('/hotels/search', 'HotelsController@search');
Route::get('/hotels/get-city-json','HotelsController@getcityListJson');
Route::get('/hotel/detail','HotelsController@hotelDetail');
Route::any('/hotel/info','HotelsController@detail');
Route::any('/hotel/room','HotelsController@HotelRoom');
Route::get('/hotel/checkout','HotelsController@hotelCheckout');
Route::any('/hotel/roomdetail','HotelsController@RoomDetail');
Route::any('/hotel/submit-booking-details','HotelsController@submitdetail');