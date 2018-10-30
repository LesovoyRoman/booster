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


Route::post('login', 'Api\UserApiController@login');
Route::post('register', 'Api\UserApiController@register');

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('/user_api', function( Request $request ){
        return $request->user('api');
    });
    Route::post('/details', 'Api\UserApiController@details');
    Route::post('/logout', 'Api\UserApiController@logout');
});


/*Route::get('/auth/callback', function (Request $request) {
    $http = new GuzzleHttp\Client;

    $response = $http->post('http://localhost:3333/oauth/token', [
        'form_params' => [
            'grant_type' => 'password',
            'client_id' => '2',
            'client_secret' => 'O6ggHgVfztWf3jar2VRhiC0G8Ddc6JxPAjRnpoPs',
            'redirect_uri' => 'http://example.com/callback',
            'code' => $request->code,
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});

Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => '2',
        'redirect_uri' => 'http://localhost:3333/auth/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('http://localhost:3333/oauth/authorize?' . $query);
});*/



