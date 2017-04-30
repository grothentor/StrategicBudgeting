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
    Route::resource('/kpis', 'KpisController');
    Route::resource('/subdivisions/{subdivision}/budgets', 'BudgetsController');
    Route::get('/budgets/{budget}/budget-values', 'BudgetValuesController@index');
    Route::post('/budgets/{budget}/budget-values', 'BudgetValuesController@store');
    Route::resource('/budget-indicators', 'BudgetIndicatorsController');
});

Route::get('/', 'HomeController@index');

Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');