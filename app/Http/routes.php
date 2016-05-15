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

    Route::get('fiscal-year/', 'Organization\Controllers\FiscalYearController@index');
    Route::get('fiscal-year/create', 'Organization\Controllers\FiscalYearController@create');
    Route::post('fiscal-year/create', 'Organization\Controllers\FiscalYearController@store');
    Route::get('fiscal-year/edit/{id}', 'Organization\Controllers\FiscalYearController@edit');
    Route::post('fiscal-year/edit/{id}', 'Organization\Controllers\FiscalYearController@update');
    Route::get('fiscal-year/delete/{id}', 'Organization\Controllers\FiscalYearController@destroy');

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
    Route::post('product/edit/{id}', 'Product\Controllers\ProductController@update');
    Route::get('product/delete/{id}', 'Product\Controllers\ProductController@destroy');

    Route::get('class-subject-map', 'School\Controllers\ClassSubjectMapController@index');
    Route::get('class-subject-map/map/{id}', 'School\Controllers\ClassSubjectMapController@map');
    Route::get('class-subject-map/delete/{id}', 'School\Controllers\ClassSubjectMapController@destroy');

    Route::get('admission', 'School\Controllers\AdmissionController@index');
    Route::get('admission/create', 'School\Controllers\AdmissionController@create');
    Route::post('admission/create', 'School\Controllers\AdmissionController@store');

    Route::get('student-account', 'Organization\Controllers\AccountStudentController@index');
    Route::get('student-account/edit/{id}', 'Organization\Controllers\AccountStudentController@edit');
    Route::post('student-account/edit/{id}', 'Organization\Controllers\AccountStudentController@update');
    Route::get('student-account/delete/{id}', 'Organization\Controllers\AccountStudentController@destroy');

    Route::get('move-student', 'School\Controllers\MoveStudentController@index');
    Route::post('move-student/move', 'School\Controllers\MoveStudentController@move');

    Route::get('/logout', '\App\Http\Controllers\User@logout');

    Route::get('/{module?}', ['as' => 'cabinet', function ($module = null) {
        return view('cabinet.main');
    }]);

});


