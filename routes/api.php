<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



// Auth
Route::post('login', 'Api\UserApiController@login');
Route::post('register', 'Api\UserApiController@register');

/**
 * User should have auth token
 */
Route::group(['middleware' => 'auth:api'], function(){
    // Auth
    Route::post('/logout', 'Api\UserApiController@logout');

    // User Data
    Route::get('/details', 'Api\UserApiController@details');

    // Campaigns
    Route::get('/allCampaigns', 'Api\CampaignController@getAllCampaigns');
    Route::post('/campaignInfluencers', 'Api\CampaignController@getCampaignInfluencers');

    // Influencers
    Route::get('/allInfluencers', 'Api\InfluencerController@getAllInfluencers');
    Route::post('/influencerCampaigns', 'Api\InfluencerController@getInfluencerCampaigns');
});

/**
 * Bad request 400
 */
Route::any('{any}', function (){
    return response()->json(['errors' => 'Unrecognized request'], 400);
})->where('any', '.*');



