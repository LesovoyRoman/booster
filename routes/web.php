<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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

Route::group([
    'namespace' => 'Admin',
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => 'admin'
], function () {
    Route::get('/', 'AdminController@index')->name('home');
    Route::get('/{any}', 'AdminController@index');
});

Route::post('/userrole', 'HomeController@index');

Route::get('/sessionSetCsrf', 'SetCsrf@setCsrf'); // get crsf

Route::post('/authCheck', 'User@authCheck'); // check if authenticated user

Route::get('/{any}', function () { // break all routes and return app (simple page application)
    return view('app');
})->where('any', '.*')->middleware('role');

Auth::routes();


