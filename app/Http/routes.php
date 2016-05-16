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

    Route::get('fiscal-year', 'Organization\Controllers\FiscalYearController@index');
    Route::get('fiscal-year/create', 'Organization\Controllers\FiscalYearController@create');
    Route::post('fiscal-year/create', 'Organization\Controllers\FiscalYearController@store');
    Route::get('fiscal-year/edit/{id}', 'Organization\Controllers\FiscalYearController@edit');
    Route::post('fiscal-year/edit/{id}', 'Organization\Controllers\FiscalYearController@update');
    Route::get('fiscal-year/delete/{id}', 'Organization\Controllers\FiscalYearController@destroy');

    Route::get('class', 'School\Controllers\SchoolClassController@index');
    Route::get('class/create', 'School\Controllers\SchoolClassController@create');
    Route::post('class/create', 'School\Controllers\SchoolClassController@store');
    Route::get('class/edit/{id}', 'School\Controllers\SchoolClassController@edit');
    Route::post('class/edit/{id}', 'School\Controllers\SchoolClassController@update');
    Route::get('class/delete/{id}', 'School\Controllers\SchoolClassController@destroy');

    Route::get('product', 'Product\Controllers\ProductController@index');
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

    Route::get('schedule-payment', 'Accounting\Controllers\SchedulePaymentController@index');
    Route::get('schedule-payment/create', 'Accounting\Controllers\SchedulePaymentController@create');
    Route::post('schedule-payment/create', 'Accounting\Controllers\SchedulePaymentController@store');
    Route::get('schedule-payment/edit/{id}', 'Accounting\Controllers\SchedulePaymentController@edit');
    Route::post('schedule-payment/edit/{id}', 'Accounting\Controllers\SchedulePaymentController@update');
    Route::get('schedule-payment/delete/{id}', 'Accounting\Controllers\SchedulePaymentController@destroy');

    Route::get('payment', 'Accounting\Controllers\PaymentController@index');
    // Route::get('payment/create', 'Accounting\Controllers\PaymentController@create');
    // Route::post('payment/create', 'Accounting\Controllers\PaymentController@store');
    // Route::get('payment/edit/{id}', 'Accounting\Controllers\PaymentController@edit');
    // Route::post('payment/edit/{id}', 'Accounting\Controllers\PaymentController@update');
    // Route::get('payment/delete/{id}', 'Accounting\Controllers\PaymentController@destroy');

    Route::get('payment-adjustment', 'Accounting\Controllers\PaymentAdjustmentController@index');
    // Route::get('payment-adjustment/create', 'Accounting\Controllers\PaymentAdjustmentController@create');
    // Route::post('payment-adjustment/create', 'Accounting\Controllers\PaymentAdjustmentController@store');
    // Route::get('payment-adjustment/edit/{id}', 'Accounting\Controllers\PaymentAdjustmentController@edit');
    // Route::post('payment-adjustment/edit/{id}', 'Accounting\Controllers\PaymentAdjustmentController@update');
    // Route::get('payment-adjustment/delete/{id}', 'Accounting\Controllers\PaymentAdjustmentController@destroy');

    Route::get('exam-schedule', 'School\Controllers\ExamScheduleController@index');
    Route::post('exam-schedule/map-subjects', 'School\Controllers\ExamScheduleController@mapSubjects');
    Route::post('exam-schedule/schedule-rows', 'School\Controllers\ExamScheduleController@scheduleRows');
    Route::get('exam-schedule/delete', 'School\Controllers\ExamScheduleController@destroy');

    Route::get('mark-sheet', 'School\Controllers\MarkSheetController@index');
    Route::get('mark-sheet/edit/{id}', 'School\Controllers\MarkSheetController@edit');
    // Route::post('mark-sheet/edit/{id}', 'School\Controllers\MarkSheetController@update');
    // Route::get('mark-sheet/create', 'School\Controllers\MarkSheetController@create');
    // Route::post('mark-sheet/create', 'School\Controllers\MarkSheetController@store');
    // Route::get('mark-sheet/delete/{id}', 'School\Controllers\MarkSheetController@destroy');

    Route::get('mark-sheet---load', 'thirdparty\omr\Controllers\MarkSheetLoadController@index');
    // Route::post('mark-sheet---load', 'thirdparty\omr\Controllers\MarkSheetLoadController@index');

    Route::get('generate-progress', 'School\Controllers\GenerateProgressController@index');
    Route::post('generate-progress/generate-progress-for-all-classes', 'School\Controllers\GenerateProgressController@generateAll');
    Route::get('generate-progress/generate', 'School\Controllers\GenerateProgressController@generate');
    Route::get('generate-progress/re-generate', 'School\Controllers\GenerateProgressController@regenerate');



    // Route::get('generate-progress/create', 'School\Controllers\GenerateProgressController@create');
    // Route::post('generate-progress/create', 'School\Controllers\GenerateProgressController@store');
    // Route::get('generate-progress/edit/{id}', 'School\Controllers\GenerateProgressController@edit');
    // Route::post('generate-progress/edit/{id}', 'School\Controllers\GenerateProgressController@update');
    // Route::get('generate-progress/delete/{id}', 'School\Controllers\GenerateProgressController@destroy');

    Route::get('/logout', '\App\Http\Controllers\User@logout');

    Route::get('/{module?}', ['as' => 'cabinet', function ($module = null) {
        return view('cabinet.main');
    }]);

});


