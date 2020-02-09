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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test/{someData}', function(Request $request, string $someData) {
    return json_encode([
        'success' => 'True',
        'someData' => $someData,
    ]);
});

Route::get('accounts', array(
    'uses'=> 'ATBAPIController@getAccounts'
));


Route::get('/accounts/{id}/transactions', array(
    'uses' => 'ATBAPIController@getAccount'
));


Route::get('/accounts/{id}/score', array(
    'uses' => 'ATBAPIController@getSustainabilityScore'
));


Route::get('/ATBAPI', array(
    'uses' => 'ATBAPIController@fetchAPI'));

