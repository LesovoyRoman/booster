<?php


// any route of app
Route::get('/{any}', function () {
    return view('appcustom');
})->where('any', '.*')->middleware('appWay'); // checking role

// Performer
Route::group(['middleware' => 'isPerformer'], function (){
    // Campaigns
    Route::post('/getAllCampaigns', 'Performer\Campaign\CampaignController@getAllCampaigns');
    Route::post('/createNewCampaign', 'Performer\Campaign\CampaignController@addCampaign');
    Route::post('/getCampaignById', 'Performer\Campaign\CampaignController@getCampaign');
    Route::post('/updateCampaign', 'Performer\Campaign\CampaignController@updateCampaign');
    Route::post('/changeStatusCampaign', 'Performer\Campaign\CampaignController@changeStatusCampaign');

    // Gifts
    Route::post('/getAllGifts', 'Performer\Gift\GiftController@getAllGifts');
    Route::post('/createNewGift', 'Performer\Gift\GiftController@addGift');
    Route::post('/deleteGift', 'Performer\Gift\GiftController@deleteGift');
    Route::post('/getGiftById', 'Performer\Gift\GiftController@getGift');
    Route::post('/updateGift', 'Performer\Gift\GiftController@updateGift');
});

// tmp route, will be rebuilt
Route::post('/getAllUsers', 'HomeController@getAllUsers');

// getting Crsf
Route::get('/sessionSetCsrf', 'SetCsrf@setCsrf');

// check if authenticated
Route::post('/authCheck', 'User@authCheck');

Auth::routes();


