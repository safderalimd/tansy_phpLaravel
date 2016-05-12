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


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('/login', function () {
        return view('login');
    });
    Route::post('/login', 'User@login');

    Route::group(['middleware' => ['cabinet', 'menu'], 'prefix' => 'cabinet'], function() {
        Route::group(['prefix' => 'fiscalYear'], function () {
            Route::get('/', '\App\Http\Modules\Organizations\Controllers\FiscalYearController@index');

            Route::get('create', '\App\Http\Modules\Organizations\Controllers\FiscalYearController@create');
            Route::post('create', '\App\Http\Modules\Organizations\Controllers\FiscalYearController@store');

            Route::get('edit/{id}', '\App\Http\Modules\Organizations\Controllers\FiscalYearController@edit');
            Route::post('edit/{id}', '\App\Http\Modules\Organizations\Controllers\FiscalYearController@update');

            Route::get('delete/{id}', '\App\Http\Modules\Organizations\Controllers\FiscalYearController@destroy');
        });

        	Route::group(['prefix' => 'class'], function () {
        		Route::get('/', '\App\Http\Modules\School\Controllers\SchoolClassController@index');

        		Route::get('create', '\App\Http\Modules\School\Controllers\SchoolClassController@create');
        		Route::post('create', '\App\Http\Modules\School\Controllers\SchoolClassController@store');

        		Route::get('edit/{id}', '\App\Http\Modules\School\Controllers\SchoolClassController@edit');
        		Route::post('edit/{id}', '\App\Http\Modules\School\Controllers\SchoolClassController@update');

        		Route::get('delete/{id}', '\App\Http\Modules\School\Controllers\SchoolClassController@destroy');
        	});

        	Route::group(['prefix' => 'product'], function () {

                    Route::get('/', '\App\Http\Modules\Product\Controllers\ProductController@index');

                    Route::get('create', '\App\Http\Modules\Product\Controllers\ProductController@create');
                    Route::post('create', '\App\Http\Modules\Product\Controllers\ProductController@store');

                    Route::get('edit/{id}', '\App\Http\Modules\Product\Controllers\ProductController@edit');
                    Route::post('edit', '\App\Http\Modules\Product\Controllers\ProductController@update');

                    Route::get('delete/{id}', '\App\Http\Modules\Product\Controllers\ProductController@destroy');
            });


        Route::get('/logout', 'User@logout');

        Route::get('/{module?}', ['as' => 'cabinet', function ($module = null) {
            session(['cabinet.tab' => $module]);
            return view('cabinet.main');
        }]);
    });
});
