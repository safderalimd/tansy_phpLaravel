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

Route::get('/debug-exception', '\App\Http\Controllers\DebugController@debugException');
Route::get('/debug-phpinfo', '\App\Http\Controllers\DebugController@phpinfo');
Route::get('/enable-debugbar', '\App\Http\Controllers\DebugController@enableDebugbar');

Route::get('/', function () {
    return view('tansycloud');
});

Route::get('/database-error', function () {
    return view('errors.db-error');
});

Route::get('/login', '\App\Http\Controllers\UserController@index')->middleware('guest');
Route::post('/login', '\App\Http\Controllers\UserController@login')->middleware('guest');

Route::group(['middleware' => ['cabinet', 'menu', 'no-cache'], 'prefix' => 'cabinet'], function() {

    Route::get('/debug-sms', '\App\Http\Controllers\DebugController@debugSMS');

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

    Route::get('subject', 'School\Controllers\SubjectController@index');
    Route::get('subject/create', 'School\Controllers\SubjectController@create');
    Route::post('subject/create', 'School\Controllers\SubjectController@store');
    Route::get('subject/edit/{id}', 'School\Controllers\SubjectController@edit');
    Route::post('subject/edit/{id}', 'School\Controllers\SubjectController@update');
    Route::get('subject/delete/{id}', 'School\Controllers\SubjectController@destroy');

    Route::get('exam', 'School\Controllers\ExamController@index');
    Route::get('exam/create', 'School\Controllers\ExamController@create');
    Route::post('exam/create', 'School\Controllers\ExamController@store');
    Route::get('exam/edit/{id}', 'School\Controllers\ExamController@edit');
    Route::post('exam/edit/{id}', 'School\Controllers\ExamController@update');
    Route::get('exam/delete/{id}', 'School\Controllers\ExamController@destroy');

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

    Route::get('student-account/edit/{id}', 'Organization\Controllers\AccountStudentController@edit');
    Route::post('student-account/edit/{id}', 'Organization\Controllers\AccountStudentController@update');
    Route::get('student-account/delete/{id}', 'Organization\Controllers\AccountStudentController@destroy');

    Route::get('move-student', 'School\Controllers\MoveStudentController@index');
    Route::post('move-student', 'School\Controllers\MoveStudentController@move');

    Route::get('schedule-payment', 'Accounting\Controllers\SchedulePaymentController@index');
    Route::get('schedule-payment/create', 'Accounting\Controllers\SchedulePaymentController@create');
    Route::post('schedule-payment/create', 'Accounting\Controllers\SchedulePaymentController@store');
    Route::get('schedule-payment/edit/{id}', 'Accounting\Controllers\SchedulePaymentController@edit');
    Route::post('schedule-payment/edit/{id}', 'Accounting\Controllers\SchedulePaymentController@update');
    Route::get('schedule-payment/delete/{id}', 'Accounting\Controllers\SchedulePaymentController@destroy');
    Route::get('schedule-payment/create/student', 'Accounting\Controllers\SchedulePaymentController@createStudent');
    Route::post('schedule-payment/create/student', 'Accounting\Controllers\SchedulePaymentController@storeStudent');

    Route::get('payment-v1', 'Accounting\Controllers\PaymentController@index');
    Route::get('payment-v1/create', 'Accounting\Controllers\PaymentController@create');
    Route::post('payment-v1/create', 'Accounting\Controllers\PaymentController@payNow');

    Route::get('daily-expense/create', 'Accounting\Controllers\DailyExpenseController@create');
    Route::post('daily-expense/create', 'Accounting\Controllers\DailyExpenseController@store');
    Route::get('daily-expense/edit/{id}', 'Accounting\Controllers\DailyExpenseController@edit');
    Route::post('daily-expense/edit/{id}', 'Accounting\Controllers\DailyExpenseController@update');

    Route::get('fee-reimbursement', 'Accounting\Controllers\FeeReimbursementController@index');
    Route::post('fee-reimbursement', 'Accounting\Controllers\FeeReimbursementController@update');

    Route::get('close-cash-counter', 'Accounting\Controllers\CashCounterController@index');
    Route::post('close-cash-counter', 'Accounting\Controllers\CashCounterController@closeCashCounter');

    Route::group(['middleware' => 'owner'], function () {
        Route::get('payment-adjustment/{id}', 'Accounting\Controllers\PaymentAdjustmentController@index');
        Route::post('payment-adjustment/add', 'Accounting\Controllers\PaymentAdjustmentController@add');
        Route::post('payment-adjustment/edit', 'Accounting\Controllers\PaymentAdjustmentController@edit');
        Route::post('payment-adjustment/update', 'Accounting\Controllers\PaymentAdjustmentController@update');
        Route::post('payment-adjustment/delete', 'Accounting\Controllers\PaymentAdjustmentController@destroy');
    });

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

    Route::get('pdf---student-export', 'reports\School\Controllers\StudentExportController@index');
    Route::get('pdf---student-export/pdf', 'reports\School\Controllers\StudentExportController@report');

    Route::get('pdf---student-detail', 'reports\School\Controllers\StudentDetailController@index');
    Route::get('pdf---student-detail/pdf', 'reports\School\Controllers\StudentDetailController@report');

    // Route::get('pdf---daily-balance', 'reports\School\Controllers\DailyCollectionController@index');
    // Route::get('pdf---daily-balance/pdf', 'reports\School\Controllers\DailyCollectionController@report');

    Route::get('pdf---final-progress', 'reports\School\Controllers\FinalProgressController@index');
    Route::get('pdf---final-progress/pdf', 'reports\School\Controllers\FinalProgressController@report');

    Route::get('pdf---account-statement', 'reports\Accounting\Controllers\AccountStatementController@index');
    Route::get('pdf---account-statement/pdf', 'reports\Accounting\Controllers\AccountStatementController@report');

    Route::get('receipts-listing', 'reports\Accounting\Controllers\ReceiptPrintController@index');
    Route::get('pdf---receipt-v1/pdf', 'reports\Accounting\Controllers\ReceiptPrintPDFController@report');

    Route::get('progress-print---student',
        'reports\School\Controllers\ProgressPrintStudentController@index');
    Route::get('progress-print--student/pdf',
        'reports\School\Controllers\ProgressPrintStudentController@report');

    Route::get('progress-print---class',
        'reports\School\Controllers\ProgressPrintClassController@index');
    Route::get('progress-print--class/pdf',
        'reports\School\Controllers\ProgressPrintClassController@report');

    Route::get('payment-dashboard', 'dashboard\accounting\Controllers\PaymentController@index');
    Route::get('payment-dashboard/schedule-fee', 'dashboard\accounting\Controllers\PaymentController@scheduleFee');
    Route::get('payment-dashboard/discount', 'dashboard\accounting\Controllers\PaymentController@discount');

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

    Route::get('send-sms-v1', 'thirdparty\sms\Controllers\SendSmsController@general');
    Route::get('send-sms-v2', 'thirdparty\sms\Controllers\SendSmsController@generalV2');
    Route::get('send-sms---exam-results', 'thirdparty\sms\Controllers\SendSmsController@examResults');
    Route::get('send-sms---exam-schedule', 'thirdparty\sms\Controllers\SendSmsController@examSchedule');
    Route::get('send-sms---attendence', 'thirdparty\sms\Controllers\SendSmsController@attendence');
    Route::get('send-sms---fee-due', 'thirdparty\sms\Controllers\SendSmsController@feeDue');

    Route::post('send-sms-v1', 'thirdparty\sms\Controllers\SendSmsController@sendGeneral');
    Route::post('send-sms-v2', 'thirdparty\sms\Controllers\SendSmsController@sendGeneralV2');
    Route::post('send-sms---exam-results', 'thirdparty\sms\Controllers\SendSmsController@sendExamResults');
    Route::post('send-sms---exam-schedule', 'thirdparty\sms\Controllers\SendSmsController@sendExamSchedule');
    Route::post('send-sms---attendence', 'thirdparty\sms\Controllers\SendSmsController@sendAttendance');
    Route::post('send-sms---fee-due', 'thirdparty\sms\Controllers\SendSmsController@sendFeeDue');

    Route::get('daily-attendance', 'School\Controllers\AttendanceController@index');
    Route::post('daily-attendance', 'School\Controllers\AttendanceController@update');

    Route::get('holidays', 'School\Controllers\HolidaysController@index');
    Route::post('holidays', 'School\Controllers\HolidaysController@update');

    Route::get('organizations', 'Organization\Controllers\OrganizationController@index');
    Route::get('organizations/create', 'Organization\Controllers\OrganizationController@create');
    Route::post('organizations/create', 'Organization\Controllers\OrganizationController@store');
    Route::get('organizations/edit/{id}', 'Organization\Controllers\OrganizationController@edit');
    Route::post('organizations/edit/{id}', 'Organization\Controllers\OrganizationController@update');
    Route::get('organizations/delete/{id}', 'Organization\Controllers\OrganizationController@destroy');

    Route::get('pdf---due-report', 'reports\School\Controllers\FeeDueReportController@index');
    Route::get('pdf---due-report/pdf', 'reports\School\Controllers\FeeDueReportController@report');

    Route::get('client-visit/create', 'CRM\Controllers\ClientVisitController@create');
    Route::post('client-visit/create', 'CRM\Controllers\ClientVisitController@store');
    Route::get('client-visit-details', 'CRM\Controllers\ClientVisitController@detail');

    // Route::get('client-visit/edit/{id}', 'CRM\Controllers\ClientVisitController@edit');
    // Route::post('client-visit/edit/{id}', 'CRM\Controllers\ClientVisitController@update');
    // Route::get('client-visit/delete/{id}', 'CRM\Controllers\ClientVisitController@destroy');

    Route::get('/', 'Admin\Controllers\AdminController@home');
    Route::get('home', 'Admin\Controllers\AdminController@home');
    Route::get('reset-dupe', 'Admin\Controllers\AdminController@debugReset');
    Route::get('change-password', 'Admin\Controllers\ChangePasswordController@index');
    Route::post('change-password', 'Admin\Controllers\ChangePasswordController@updatePassword');

    Route::get('account-client', 'Organization\Controllers\AccountClientController@index');
    Route::get('account-client/create', 'Organization\Controllers\AccountClientController@create');
    Route::post('account-client/create', 'Organization\Controllers\AccountClientController@store');
    Route::get('account-client/edit/{id}', 'Organization\Controllers\AccountClientController@edit');
    Route::post('account-client/edit/{id}', 'Organization\Controllers\AccountClientController@update');
    Route::get('account-client/delete/{id}', 'Organization\Controllers\AccountClientController@destroy');

    Route::get('account-agent', 'Organization\Controllers\AccountAgentController@index');
    Route::get('account-agent/create', 'Organization\Controllers\AccountAgentController@create');
    Route::post('account-agent/create', 'Organization\Controllers\AccountAgentController@store');
    Route::get('account-agent/edit/{id}', 'Organization\Controllers\AccountAgentController@edit');
    Route::post('account-agent/edit/{id}', 'Organization\Controllers\AccountAgentController@update');
    Route::get('account-agent/delete/{id}', 'Organization\Controllers\AccountAgentController@destroy');

    Route::get('account-employee', 'Organization\Controllers\AccountEmployeeController@index');
    Route::get('account-employee/create', 'Organization\Controllers\AccountEmployeeController@create');
    Route::post('account-employee/create', 'Organization\Controllers\AccountEmployeeController@store');
    Route::get('account-employee/edit/{id}', 'Organization\Controllers\AccountEmployeeController@edit');
    Route::post('account-employee/edit/{id}', 'Organization\Controllers\AccountEmployeeController@update');
    Route::get('account-employee/delete/{id}', 'Organization\Controllers\AccountEmployeeController@destroy');

    Route::get('grid-permission', 'System\Controllers\GridPermissionController@index');
    Route::post('grid-permission', 'System\Controllers\GridPermissionController@update');

    Route::get('grid-setup', 'System\Controllers\GridSetupController@index');
    Route::post('grid-setup', 'System\Controllers\GridSetupController@update');

    Route::get('help', 'System\Controllers\HelpController@index');

    Route::get('my-org', 'System\Controllers\OwnerOrganizationController@edit');
    Route::post('my-org', 'System\Controllers\OwnerOrganizationController@update');

    Route::get('manage-lookups', 'System\Controllers\ManageLookupsController@index');
    Route::post('manage-lookups/store', 'System\Controllers\ManageLookupsController@store');
    Route::post('manage-lookups/update', 'System\Controllers\ManageLookupsController@update');

    Route::get('custom-fields', 'System\Controllers\CustomFieldsController@index');
    Route::get('custom-fields/create', 'System\Controllers\CustomFieldsController@create');
    Route::post('custom-fields/create', 'System\Controllers\CustomFieldsController@store');
    Route::get('custom-fields/edit/{id}', 'System\Controllers\CustomFieldsController@edit');
    Route::post('custom-fields/edit/{id}', 'System\Controllers\CustomFieldsController@update');

    Route::get('/logout', '\App\Http\Controllers\UserController@logout');

    Route::get('/img/student/{id}', '\App\Http\Controllers\ImageController@studentImage');
    Route::get('/img/school-logo/logo.png', '\App\Http\Controllers\ImageController@schoolLogo');

    Route::get('/sms-batch-details', '\App\Http\Controllers\GridController@smsBatchDetails');
    Route::get('/{module}', '\App\Http\Controllers\GridController@index');

});

