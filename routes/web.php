<?php


// any route of app
Route::get('/{any}', function () {
    return view('appcustom');
})->where('any', '.*')->middleware('appWay'); // checking role

// Configs
Route::post('/getConfigEnums', 'Helpers\ConfigSender@returnConfigEnumsJson');


// For each role
Route::group(['middleware' => 'roleExists'], function () {
    // Campaign
    Route::post('/getAllCampaigns', 'Common\Campaign\CampaignController@getAllCampaigns');
    Route::post('/getCampaignById', 'Common\Campaign\CampaignController@getCampaign');

    // Gift
    Route::post('/getAllGifts', 'Common\Gift\GiftController@getAllGifts');
    Route::post('/getGiftById', 'Common\Gift\GiftController@getGift');

    // User
    Route::post('/currentUserChangePass', 'Common\User\UserController@changePass');
    Route::post('/currentUserChangeEmail', 'Common\User\UserController@changeEmail');
    Route::post('/currentUserChangeAvatar', 'Common\User\UserController@userChangeAvatar');
});


// Performer
Route::group(['middleware' => 'isPerformer'], function (){
    // Campaigns
    Route::post('/createNewCampaign', 'Performer\Campaign\CampaignController@addCampaign');
    Route::post('/updateCampaign', 'Performer\Campaign\CampaignController@updateCampaign');
    Route::post('/changeStatusCampaign', 'Performer\Campaign\CampaignController@changeStatusCampaign');

    // Gifts
    Route::post('/createNewGift', 'Performer\Gift\GiftController@addGift');
    Route::post('/deleteGift', 'Performer\Gift\GiftController@deleteGift');
    Route::post('/updateGift', 'Performer\Gift\GiftController@updateGift');
    Route::post('/changeStatusGift', 'Performer\Gift\GiftController@changeStatusGift');

    // User
    Route::post('/currentPerformerGetData', 'Performer\PerformerController@getCurrentPerformer');
    Route::post('/currentPerformerSetData', 'Performer\PerformerController@updatePerformer');
});

// Influencer
Route::group(['middleware' => 'isInfluencer'], function (){
    //User
    Route::post('/currentInfluencerGetData', 'Influencer\InfluencerController@getCurrentInfluencer');
    Route::post('/currentInfluencerSetData', 'Influencer\InfluencerController@updateInfluencer');

    // Campaign
    Route::post('/acceptCampaign', 'Influencer\Campaign\CampaignController@acceptCampaign');
    Route::post('/declineCampaign', 'Influencer\Campaign\CampaignController@declineCampaign');

    // Campaign points
    Route::post('/influencerCampaignPoints', 'Influencer\Campaign\CampaignController@influencerCampaignsPoints');
});

// @todo tmp route, will be rebuilt
Route::post('/getAllUsers', 'HomeController@getAllUsers');

// getting Crsf
Route::get('/sessionSetCsrf', 'SetCsrf@setCsrf');

// check if authenticated
Route::post('/authCheck', 'Common\User\UserController@authCheck');
Route::post('/roleCheck', 'Common\User\UserController@getRole');


Auth::routes();


