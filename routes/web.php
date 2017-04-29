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

Route::group(['middleware' => 'auth'], function() {
    Route::resource('/subdivisions', 'SubdivisionsController');
    Route::resource('/kpi', 'KpisController');
    Route::resource('/subdivisions/{subdivision}/budgets', 'BudgetsController');
    Route::resource('/budgets/{budget}/budget-indicators', 'BudgetIndicatorsController');
});

Route::get('/', 'HomeController@index');