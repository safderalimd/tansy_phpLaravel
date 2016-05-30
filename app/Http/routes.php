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
    return redirect('/cabinet');
});

Route::get('/phpinfo', function () {
    phpinfo();
    die();
});

Route::get('/debug', function() {
    return view('errors.debug');
});

Route::get('/login', '\App\Http\Controllers\User@index'); //->middleware('guest');
Route::post('/login', '\App\Http\Controllers\User@login');

Route::group(['middleware' => ['cabinet', 'menu'], 'prefix' => 'cabinet'], function() {

    Route::get('/debug', function() {
        return redirect('/debug');
    });

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
    Route::get('class-subject-map/map/{classId}/{subjectId}', 'School\Controllers\ClassSubjectMapController@map');
    Route::get('class-subject-map/delete/{classId}/{subjectId}', 'School\Controllers\ClassSubjectMapController@destroy');

    Route::get('admission', 'School\Controllers\AdmissionController@index');
    Route::get('admission/create', 'School\Controllers\AdmissionController@create');
    Route::post('admission/create', 'School\Controllers\AdmissionController@store');
    Route::get('admission/edit/{id}', 'School\Controllers\AdmissionController@edit');
    Route::post('admission/edit/{id}', 'School\Controllers\AdmissionController@update');
    Route::get('admission/delete/{id}', 'School\Controllers\AdmissionController@destroy');
    Route::post('admission/move-students', 'School\Controllers\AdmissionController@moveStudents');

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
    Route::get('payment/create', 'Accounting\Controllers\PaymentController@create');
    Route::post('payment/pay-now', 'Accounting\Controllers\PaymentController@payNow');

    Route::get('payment-adjustment/{id}', 'Accounting\Controllers\PaymentAdjustmentController@index');
    Route::post('payment-adjustment/add', 'Accounting\Controllers\PaymentAdjustmentController@add');
    Route::post('payment-adjustment/edit', 'Accounting\Controllers\PaymentAdjustmentController@edit');
    Route::post('payment-adjustment/delete', 'Accounting\Controllers\PaymentAdjustmentController@destroy');

    Route::get('exam-schedule', 'School\Controllers\ExamScheduleController@index');
    Route::post('exam-schedule/map-subjects', 'School\Controllers\ExamScheduleController@mapSubjects');
    Route::post('exam-schedule/schedule-rows', 'School\Controllers\ExamScheduleController@scheduleRows');
    Route::get('exam-schedule/delete', 'School\Controllers\ExamScheduleController@destroy');

    Route::get('mark-sheet', 'School\Controllers\MarkSheetController@index');
    Route::get('mark-sheet/edit', 'School\Controllers\MarkSheetController@edit');
    Route::get('mark-sheet/lock', 'School\Controllers\MarkSheetController@lock');
    Route::get('mark-sheet/unlock', 'School\Controllers\MarkSheetController@unlock');
    Route::post('mark-sheet/save', 'School\Controllers\MarkSheetController@save');

    Route::get('mark-sheet---load', 'thirdparty\omr\Controllers\MarkSheetLoadController@index');
    // Route::post('mark-sheet---load', 'thirdparty\omr\Controllers\MarkSheetLoadController@index');

    Route::get('generate-progress', 'School\Controllers\GenerateProgressController@index');
    Route::post('generate-progress/generate-progress-for-all-classes', 'School\Controllers\GenerateProgressController@generateAll');
    Route::get('generate-progress/generate', 'School\Controllers\GenerateProgressController@generate');
    Route::get('generate-progress/re-generate', 'School\Controllers\GenerateProgressController@regenerate');

    Route::get('student-export', 'reports\School\Controllers\StudentExportController@index');
    Route::get('student-export/pdf', 'reports\School\Controllers\StudentExportController@report');

    Route::get('receipt-report/{id}', 'reports\Accounting\Controllers\ReceiptPrintController@index');
    Route::get('receipt-report/pdf/{id}', 'reports\Accounting\Controllers\ReceiptPrintController@report');

    Route::get('progress-print---student',
        'reports\School\Controllers\ProgressPrintStudentController@index');
    Route::get('progress-print--student/pdf',
        'reports\School\Controllers\ProgressPrintStudentController@report');

    Route::get('progress-print---class',
        'reports\School\Controllers\ProgressPrintClassController@index');
    Route::get('progress-print--class/pdf',
        'reports\School\Controllers\ProgressPrintClassController@report');

    Route::get('fee-dashboard-v1', 'dashboard\accounting\Controllers\PaymentController@index');
    Route::get('fee-dashboard-v1/schedule-fee', 'dashboard\accounting\Controllers\PaymentController@scheduleFee');
    Route::get('fee-dashboard-v1/discount', 'dashboard\accounting\Controllers\PaymentController@discount');

    Route::get('sms-dashboard', 'dashboard\sms\Controllers\SmsController@index');

    Route::get('student-dashboard', 'dashboard\school\Controllers\StudentController@index');
    Route::get('student-dashboard/overall-grade', 'dashboard\school\Controllers\StudentController@overallGrade');
    Route::get('student-dashboard/fee-due', 'dashboard\school\Controllers\StudentController@feeDueDetails');
    Route::get('student-dashboard/sms-history', 'dashboard\school\Controllers\StudentController@smsHistory');

    Route::get('exam-dashboard', 'dashboard\school\Controllers\ExamController@index');
    Route::get('exam-dashboard/toppers', 'dashboard\school\Controllers\ExamController@toppers');
    Route::get('exam-dashboard/failed-students', 'dashboard\school\Controllers\ExamController@failedStudents');
    Route::get('exam-dashboard/absentees', 'dashboard\school\Controllers\ExamController@absentees');

    Route::get('load-student-data', 'loaddata\School\Controllers\StudentDataController@index');
    Route::post('load-student-data', 'loaddata\School\Controllers\StudentDataController@store');

    Route::get('send-sms---general', 'thirdparty\sms\Controllers\SendSmsController@general');
    Route::get('send-sms---exam-results', 'thirdparty\sms\Controllers\SendSmsController@examResults');
    Route::get('send-sms---attendence', 'thirdparty\sms\Controllers\SendSmsController@attendence');
    Route::post('send-sms---attendence', 'thirdparty\sms\Controllers\SendSmsController@attendence');
    Route::get('send-sms---fee-due', 'thirdparty\sms\Controllers\SendSmsController@feeDue');

    Route::post('send-sms---general', 'thirdparty\sms\Controllers\SendSmsController@sendGeneral');
    Route::post('send-sms---exam-results', 'thirdparty\sms\Controllers\SendSmsController@sendExamResults');
    Route::post('send-sms---attendence/send', 'thirdparty\sms\Controllers\SendSmsController@sendAttendence');
    Route::post('send-sms---fee-due', 'thirdparty\sms\Controllers\SendSmsController@sendFeeDue');

    Route::get('/logout', '\App\Http\Controllers\User@logout');

    Route::get('/{module?}', ['as' => 'cabinet', function ($module = null) {
        return view('cabinet.main');
    }]);

});


