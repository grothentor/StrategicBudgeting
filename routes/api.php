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

Route::post('calculate', 'KpisController@calculate');
Route::get('calculate/{companyId}/{budgetValue}', 'KpisController@calculate');
Route::get('kpis', 'KpisController@index');

Route::get('companies', 'CompaniesController@index');
Route::post('companies', 'CompaniesController@store');
