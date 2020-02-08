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


Route::get('/customer/{id}', array(
    'uses' => 'ATBAPIController@getCustomer'));


Route::get('/score/{id}', array(
    'uses' => 'ATBAPIController@getSustainabilityScore'
));


//Route::post('/score', array(
//    'uses' => 'ATBAPIController@updateSustainabilyScore'
//));




Route::get('/ATBAPI', array(
    'uses' => 'ATBAPIController@fetchAPI'));

