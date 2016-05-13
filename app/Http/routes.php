<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', '\App\Http\Controllers\User@index'); //->middleware('guest');
Route::post('/login', '\App\Http\Controllers\User@login');

Route::group(['middleware' => ['cabinet', 'menu'], 'prefix' => 'cabinet'], function() {

    Route::get('fiscalYear/', 'Organizations\Controllers\FiscalYearController@index');
    Route::get('fiscalYear/create', 'Organizations\Controllers\FiscalYearController@create');
    Route::post('fiscalYear/create', 'Organizations\Controllers\FiscalYearController@store');
    Route::get('fiscalYear/edit/{id}', 'Organizations\Controllers\FiscalYearController@edit');
    Route::post('fiscalYear/edit/{id}', 'Organizations\Controllers\FiscalYearController@update');
    Route::get('fiscalYear/delete/{id}', 'Organizations\Controllers\FiscalYearController@destroy');

    Route::get('class/', 'School\Controllers\SchoolClassController@index');
    Route::get('class/create', 'School\Controllers\SchoolClassController@create');
    Route::post('class/create', 'School\Controllers\SchoolClassController@store');
    Route::get('class/edit/{id}', 'School\Controllers\SchoolClassController@edit');
    Route::post('class/edit/{id}', 'School\Controllers\SchoolClassController@update');
    Route::get('class/delete/{id}', 'School\Controllers\SchoolClassController@destroy');

    Route::get('product/', 'Product\Controllers\ProductController@index');
    Route::get('product/create', 'Product\Controllers\ProductController@create');
    Route::post('product/create', 'Product\Controllers\ProductController@store');
    Route::get('product/edit/{id}', 'Product\Controllers\ProductController@edit');
    Route::post('product/update/{id}', 'Product\Controllers\ProductController@update');
    Route::get('product/delete/{id}', 'Product\Controllers\ProductController@destroy');

    Route::get('/logout', '\App\Http\Controllers\User@logout');

    Route::get('/{module?}', ['as' => 'cabinet', function ($module = null) {
        return view('cabinet.main');
    }]);

});


