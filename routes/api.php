<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('user_accessible')->get('/user', function (Request $request) {
    return response()->json($request->user());
});

Route::middleware('user_accessible')->get('/companies/{query}', 'UserCompanyController@getCompany');
Route::middleware('user_accessible')->post('/addmycompany', 'UserCompanyController@addMyCompany');
Route::middleware('user_accessible')->get('/getmycompany', 'UserCompanyController@getMyCompany');
Route::middleware('user_accessible')->delete('/deletemycompany', 'UserCompanyController@deleteMyCompany');

