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

Route::get('/{any}', function () {
    return view('appcustom');
})->where('any', '.*')->middleware('appWay'); // checking role

Route::group(['middleware' => 'isPerformer'], function (){
    // Campaigns
    Route::post('/getAllCampaigns', 'Campaign\CampaignController@getAllCampaigns');
    Route::post('/createNewCampaign', 'Campaign\CampaignController@addCampaign');

    // Gifts
    Route::post('/getAllGifts', 'Gift\GiftController@getAllGifts');
    Route::post('/createNewGift', 'Gift\GiftController@addGift');
});

Route::post('/getAllUsers', 'HomeController@getAllUsers');

Route::get('/sessionSetCsrf', 'SetCsrf@setCsrf');

Route::post('/authCheck', 'User@authCheck');

Auth::routes();


