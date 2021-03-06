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
Route::get('/debug-sms', '\App\Http\Controllers\DebugController@debugSMS')->middleware('cabinet');


Route::get('/', '\App\Http\Controllers\HomeController@index');
Route::get('/database-error', '\App\Http\Controllers\HomeController@databaseError');
Route::post('/contact', '\App\Http\Controllers\ContactController@send');


Route::group(['middleware' => 'guest'], function() {
    Route::get('/login', '\App\Http\Controllers\Auth\AuthController@getLogin');
    Route::post('/login', '\App\Http\Controllers\Auth\AuthController@postLogin');

    Route::get('/forgot-password', '\App\Http\Controllers\ForgotPasswordController@index');
    Route::post('/forgot-password', '\App\Http\Controllers\ForgotPasswordController@validateForgotPassword');
    Route::get('/forgot-password/otp', '\App\Http\Controllers\ForgotPasswordController@otp');
    Route::post('/forgot-password/otp', '\App\Http\Controllers\ForgotPasswordController@validateOTP');
    Route::get('/forgot-password/otp-resend', '\App\Http\Controllers\ForgotPasswordController@otpResend');
    Route::get('/forgot-password/reset', '\App\Http\Controllers\ForgotPasswordController@password');
    Route::post('/forgot-password/reset', '\App\Http\Controllers\ForgotPasswordController@updatePassword');
});


Route::group(['middleware' => ['cabinet', 'menu', 'no-cache'], 'prefix' => 'cabinet'], function() {

    // Admin Links Group
    Route::get('/', 'Admin\Controllers\AdminController@home');
    Route::get('home', 'Admin\Controllers\AdminController@home');
    Route::get('reset-dupe', 'Admin\Controllers\AdminController@debugReset');
    Route::get('change-password', 'Admin\Controllers\ChangePasswordController@index');
    Route::post('change-password', 'Admin\Controllers\ChangePasswordController@updatePassword');


    // Setup Links Group
    Route::get('manage-lookups', 'System\Controllers\ManageLookupsController@index');
    Route::post('manage-lookups/store', 'System\Controllers\ManageLookupsController@store');
    Route::post('manage-lookups/update', 'System\Controllers\ManageLookupsController@update');

    Route::get('time-table-period', 'System\Controllers\TimeTablePeriodController@index');
    Route::post('time-table-period/store', 'System\Controllers\TimeTablePeriodController@store');
    Route::post('time-table-period/update', 'System\Controllers\TimeTablePeriodController@update');

    Route::get('custom-fields', 'System\Controllers\CustomFieldsController@index');
    Route::get('custom-fields/create', 'System\Controllers\CustomFieldsController@create');
    Route::post('custom-fields/create', 'System\Controllers\CustomFieldsController@store');
    Route::get('custom-fields/edit/{id}', 'System\Controllers\CustomFieldsController@edit');
    Route::post('custom-fields/edit/{id}', 'System\Controllers\CustomFieldsController@update');

    Route::get('grid-permission', 'System\Controllers\GridPermissionController@index');
    Route::post('grid-permission', 'System\Controllers\GridPermissionController@update');

    Route::get('grid-setup', 'System\Controllers\GridSetupController@index');
    Route::post('grid-setup', 'System\Controllers\GridSetupController@update');

    Route::get('product', 'Product\Controllers\ProductController@index');
    Route::get('product/create', 'Product\Controllers\ProductController@create');
    Route::post('product/create', 'Product\Controllers\ProductController@store');
    Route::get('product/edit/{id}', 'Product\Controllers\ProductController@edit');
    Route::post('product/edit/{id}', 'Product\Controllers\ProductController@update');
    Route::get('product/delete/{id}', 'Product\Controllers\ProductController@destroy');

    Route::get('progress-grade-setup', 'School\Controllers\ProgressGradeSetupController@index');
    Route::post('progress-grade-setup/store', 'School\Controllers\ProgressGradeSetupController@store');
    Route::post('progress-grade-setup/update', 'School\Controllers\ProgressGradeSetupController@update');
    Route::post('progress-grade-setup/delete/{id}', 'School\Controllers\ProgressGradeSetupController@destroy');

    Route::get('exam', 'School\Controllers\ExamController@index');
    Route::get('exam/create', 'School\Controllers\ExamController@create');
    Route::post('exam/create', 'School\Controllers\ExamController@store');
    Route::get('exam/edit/{id}', 'School\Controllers\ExamController@edit');
    Route::post('exam/edit/{id}', 'School\Controllers\ExamController@update');
    Route::get('exam/delete/{id}', 'School\Controllers\ExamController@destroy');

    Route::get('exam-schedule', 'School\Controllers\ExamScheduleController@index');
    Route::get('exam-schedule/edit/{id}', 'School\Controllers\ExamScheduleController@edit');
    Route::post('exam-schedule/edit/{id}', 'School\Controllers\ExamScheduleController@update');
    Route::post('exam-schedule/map-subjects', 'School\Controllers\ExamScheduleController@mapSubjects');
    Route::post('exam-schedule/schedule-rows', 'School\Controllers\ExamScheduleController@scheduleRows');
    Route::get('exam-schedule/paper-2', 'School\Controllers\ExamScheduleController@paper2');
    Route::get('exam-schedule/delete', 'School\Controllers\ExamScheduleController@destroy');

    Route::get('exam-setup', 'School\Controllers\ExamSetupController@index');
    Route::get('exam-setup/create', 'School\Controllers\ExamSetupController@create');
    Route::post('exam-setup/create', 'School\Controllers\ExamSetupController@store');
    Route::get('exam-setup/edit/{id}', 'School\Controllers\ExamSetupController@edit');
    Route::post('exam-setup/edit/{id}', 'School\Controllers\ExamSetupController@update');
    Route::get('exam-setup/delete', 'School\Controllers\ExamSetupController@destroy');
    Route::post('exam-setup/copy', 'School\Controllers\ExamSetupController@copy');
    Route::post('exam-setup/delete-multiple', 'School\Controllers\ExamSetupController@deleteMultiple');

    Route::get('progress-report-version', 'System\Controllers\ProgressReportVersionController@index');
    Route::post('progress-report-version', 'System\Controllers\ProgressReportVersionController@update');


    // Dashboards Links Group
    Route::get('payment-dashboard', 'dashboard\accounting\Controllers\PaymentController@index');
    Route::get('payment-dashboard/schedule-fee', 'dashboard\accounting\Controllers\PaymentController@scheduleFee');
    Route::get('payment-dashboard/discount', 'dashboard\accounting\Controllers\PaymentController@discount');

    Route::get('sms-dashboard', 'dashboard\sms\Controllers\DashboardSmsController@index');

    Route::get('exam-dashboard', 'dashboard\school\Controllers\ExamController@index');
    Route::get('exam-dashboard/toppers', 'dashboard\school\Controllers\ExamController@toppers');
    Route::get('exam-dashboard/failed-students', 'dashboard\school\Controllers\ExamController@failedStudents');
    Route::get('exam-dashboard/absentees', 'dashboard\school\Controllers\ExamController@absentees');

    Route::get('student-dashboard', 'dashboard\school\Controllers\StudentController@index');
    Route::get('student-dashboard/overall-grade', 'dashboard\school\Controllers\StudentController@overallGrade');
    Route::get('student-dashboard/fee-due', 'dashboard\school\Controllers\StudentController@feeDueDetails');
    Route::get('student-dashboard/sms-history', 'dashboard\school\Controllers\StudentController@smsHistory');


    // Organization Links Group
    Route::get('my-org', 'System\Controllers\OwnerOrganizationController@edit');
    Route::post('my-org', 'System\Controllers\OwnerOrganizationController@update');

    Route::get('organizations', 'Organization\Controllers\OrganizationController@index');
    Route::get('organizations/create', 'Organization\Controllers\OrganizationController@create');
    Route::post('organizations/create', 'Organization\Controllers\OrganizationController@store');
    Route::get('organizations/edit/{id}', 'Organization\Controllers\OrganizationController@edit');
    Route::post('organizations/edit/{id}', 'Organization\Controllers\OrganizationController@update');
    Route::get('organizations/delete/{id}', 'Organization\Controllers\OrganizationController@destroy');

    Route::get('fiscal-year', 'Organization\Controllers\FiscalYearController@index');
    Route::get('fiscal-year/create', 'Organization\Controllers\FiscalYearController@create');
    Route::post('fiscal-year/create', 'Organization\Controllers\FiscalYearController@store');
    Route::get('fiscal-year/edit/{id}', 'Organization\Controllers\FiscalYearController@edit');
    Route::post('fiscal-year/edit/{id}', 'Organization\Controllers\FiscalYearController@update');
    Route::get('fiscal-year/delete/{id}', 'Organization\Controllers\FiscalYearController@destroy');

    Route::get('account-employee', 'Organization\Controllers\AccountEmployeeController@index');
    Route::get('account-employee/create', 'Organization\Controllers\AccountEmployeeController@create');
    Route::post('account-employee/create', 'Organization\Controllers\AccountEmployeeController@store');
    Route::get('account-employee/edit/{id}', 'Organization\Controllers\AccountEmployeeController@edit');
    Route::post('account-employee/edit/{id}', 'Organization\Controllers\AccountEmployeeController@update');
    Route::get('account-employee/delete/{id}', 'Organization\Controllers\AccountEmployeeController@destroy');

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

    Route::get('account---quick-update', 'Organization\Controllers\QuickUpdateController@index');
    Route::post('account---quick-update', 'Organization\Controllers\QuickUpdateController@update');


    // Calendar Links Group
    Route::get('events', 'School\Controllers\EventsController@index');
    Route::get('events/create', 'School\Controllers\EventsController@create');
    Route::post('events/create', 'School\Controllers\EventsController@store');
    Route::get('events/edit/{id}', 'School\Controllers\EventsController@edit');
    Route::post('events/edit/{id}', 'School\Controllers\EventsController@update');
    Route::get('events/delete/{id}', 'School\Controllers\EventsController@destroy');

    Route::get('holidays', 'School\Controllers\HolidaysController@index');
    Route::post('holidays', 'School\Controllers\HolidaysController@update');


    // Communication Links Group
    Route::get('inbox', 'Communication\Controllers\InboxController@index');
    Route::get('inbox/new', 'Communication\Controllers\InboxController@newMessage');
    Route::post('inbox/new', 'Communication\Controllers\InboxController@send');
    Route::post('inbox/delete', 'Communication\Controllers\InboxController@delete');
    Route::get('inbox/detail', 'Communication\Controllers\InboxController@detail');

    Route::get('send-mail', 'Communication\Controllers\SendMailController@index');
    Route::post('send-mail/delete', 'Communication\Controllers\SendMailController@delete');
    Route::get('send-mail/detail', 'Communication\Controllers\SendMailController@detail');


    // Payment Links Group
    Route::get('schedule-payment', 'Accounting\Controllers\SchedulePaymentController@index');
    Route::get('schedule-payment/create', 'Accounting\Controllers\SchedulePaymentController@create');
    Route::post('schedule-payment/create', 'Accounting\Controllers\SchedulePaymentController@store');
    Route::get('schedule-payment/edit/{id}', 'Accounting\Controllers\SchedulePaymentController@edit');
    Route::post('schedule-payment/edit/{id}', 'Accounting\Controllers\SchedulePaymentController@update');
    Route::get('schedule-payment/delete/{id}', 'Accounting\Controllers\SchedulePaymentController@destroy');
    Route::get('schedule-payment/create/student', 'Accounting\Controllers\SchedulePaymentController@createStudent');
    Route::post('schedule-payment/create/student', 'Accounting\Controllers\SchedulePaymentController@storeStudent');

    Route::get('schedule-payment-v2', 'Accounting\Controllers\SchedulePaymentV2Controller@index');
    Route::post('schedule-payment-v2', 'Accounting\Controllers\SchedulePaymentV2Controller@update');

    Route::get('payment-v1', 'Accounting\Controllers\PaymentController@index');
    Route::get('payment-v1/create', 'Accounting\Controllers\PaymentController@create');
    Route::post('payment-v1/create', 'Accounting\Controllers\PaymentController@payNow');

    Route::get('payment-v2', 'Accounting\Controllers\FeeReimbursementController@index');
    Route::post('payment-v2', 'Accounting\Controllers\FeeReimbursementController@update');

    Route::get('daily-expense/create', 'Accounting\Controllers\DailyExpenseController@create');
    Route::post('daily-expense/create', 'Accounting\Controllers\DailyExpenseController@store');
    Route::get('daily-expense/edit/{id}', 'Accounting\Controllers\DailyExpenseController@edit');
    Route::post('daily-expense/edit/{id}', 'Accounting\Controllers\DailyExpenseController@update');

    Route::get('close-cash-counter', 'Accounting\Controllers\CashCounterController@index');
    Route::post('close-cash-counter', 'Accounting\Controllers\CashCounterController@closeCashCounter');

    Route::get('pdf---due-report', 'reports\School\Controllers\FeeDueReportController@index');
    Route::get('pdf---due-report/pdf', 'reports\School\Controllers\FeeDueReportController@report');

    Route::get('pdf---account-statement', 'reports\Accounting\Controllers\AccountStatementController@index');
    Route::get('pdf---account-statement/pdf', 'reports\Accounting\Controllers\AccountStatementController@report');

    Route::group(['middleware' => 'owner'], function () {
        Route::get('payment-adjustment/{id}', 'Accounting\Controllers\PaymentAdjustmentController@index');
        Route::post('payment-adjustment/add', 'Accounting\Controllers\PaymentAdjustmentController@add');
        Route::post('payment-adjustment/edit', 'Accounting\Controllers\PaymentAdjustmentController@edit');
        Route::post('payment-adjustment/update', 'Accounting\Controllers\PaymentAdjustmentController@update');
        Route::post('payment-adjustment/delete', 'Accounting\Controllers\PaymentAdjustmentController@destroy');
    });

    Route::get('receipts-listing', 'reports\Accounting\Controllers\ReceiptPrintController@index');

    Route::get('pdf---receipt-v1/pdf', 'reports\Accounting\Controllers\ReceiptPrintPDFController@reportV1');
    Route::get('pdf---receipt-v2/pdf', 'reports\Accounting\Controllers\ReceiptPrintPDFController@reportV2');

    // School Links Group
    Route::get('class', 'School\Controllers\SchoolClassController@index');
    Route::get('class/create', 'School\Controllers\SchoolClassController@create');
    Route::post('class/create', 'School\Controllers\SchoolClassController@store');
    Route::get('class/edit/{id}', 'School\Controllers\SchoolClassController@edit');
    Route::post('class/edit/{id}', 'School\Controllers\SchoolClassController@update');
    Route::get('class/delete/{id}', 'School\Controllers\SchoolClassController@destroy');

    Route::get('subject', 'School\Controllers\SubjectController@index');
    Route::get('subject/create', 'School\Controllers\SubjectController@create');
    Route::post('subject/create', 'School\Controllers\SubjectController@store');
    Route::get('subject/edit/{id}', 'School\Controllers\SubjectController@edit');
    Route::post('subject/edit/{id}', 'School\Controllers\SubjectController@update');
    Route::get('subject/delete/{id}', 'School\Controllers\SubjectController@destroy');

    Route::get('class-subject-map', 'School\Controllers\ClassSubjectMapController@index');
    Route::get('class-subject-map/map/{classId}/{subjectId}', 'School\Controllers\ClassSubjectMapController@map');
    Route::get('class-subject-map/delete/{classId}/{subjectId}', 'School\Controllers\ClassSubjectMapController@destroy');

    Route::get('teacher-subject-map', 'Teacher\Controllers\TeacherSubjectMapController@index');
    Route::post('teacher-subject-map', 'Teacher\Controllers\TeacherSubjectMapController@update');

    Route::get('class-time-table', 'Teacher\Controllers\ClassTimeTableController@index');
    Route::post('class-time-table', 'Teacher\Controllers\ClassTimeTableController@update');

    Route::get('monthly-attendance', 'Teacher\Controllers\MonthlyAttendanceController@index');
    Route::post('monthly-attendance', 'Teacher\Controllers\MonthlyAttendanceController@update');

    Route::get('pdf---time-table', 'reports\School\Controllers\TimeTableController@index');
    Route::get('pdf---time-table/pdf', 'reports\School\Controllers\TimeTableController@report');


    // Student Links Group
    Route::get('load-student-data', 'loaddata\School\Controllers\StudentDataController@index');
    Route::post('load-student-data', 'loaddata\School\Controllers\StudentDataController@store');

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
    Route::post('student-account/delete-image/{id}', 'Organization\Controllers\AccountStudentController@deleteImage');

    Route::get('move-student', 'School\Controllers\MoveStudentController@index');
    Route::post('move-student', 'School\Controllers\MoveStudentController@move');

    Route::get('pdf---student-detail', 'reports\School\Controllers\StudentDetailController@index');
    Route::get('pdf---student-detail/pdf', 'reports\School\Controllers\StudentDetailController@report');

    Route::get('pdf---student', 'reports\School\Controllers\OneStudentController@index');
    Route::get('pdf---student/pdf', 'reports\School\Controllers\OneStudentController@report');

    Route::get('pdf---dice', 'reports\School\Controllers\DICEController@index');
    Route::get('pdf---dice/pdf', 'reports\School\Controllers\DICEController@report');
    Route::get('pdf---dice/csv', 'reports\School\Controllers\DICEController@csv');


    // Teacher Links Group
    Route::get('daily-attendance', 'School\Controllers\AttendanceController@index');
    Route::post('daily-attendance', 'School\Controllers\AttendanceController@update');

    Route::get('homework', 'Teacher\Controllers\HomeworkController@index');
    Route::get('homework/create', 'Teacher\Controllers\HomeworkController@create');
    Route::post('homework/create', 'Teacher\Controllers\HomeworkController@store');
    Route::get('homework/edit/{id}', 'Teacher\Controllers\HomeworkController@edit');
    Route::post('homework/edit/{id}', 'Teacher\Controllers\HomeworkController@update');
    Route::get('homework/delete/{id}', 'Teacher\Controllers\HomeworkController@destroy');

    Route::get('exam-syllabus', 'Teacher\Controllers\ExamSyllabusController@index');
    Route::get('exam-syllabus/edit/{id}', 'Teacher\Controllers\ExamSyllabusController@edit');
    Route::post('exam-syllabus/edit/{id}', 'Teacher\Controllers\ExamSyllabusController@update');
    Route::get('exam-syllabus/delete/{id}', 'Teacher\Controllers\ExamSyllabusController@destroy');

    Route::get('teacher---quick-update', 'Teacher\Controllers\TeacherQuickUpdateController@index');
    Route::post('teacher---quick-update', 'Teacher\Controllers\TeacherQuickUpdateController@update');


    // Exam Links Group
    Route::get('mark-sheet', 'School\Controllers\MarkSheetController@index');
    Route::get('mark-sheet/edit', 'School\Controllers\MarkSheetController@edit');
    Route::get('mark-sheet/lock', 'School\Controllers\MarkSheetController@lock');
    Route::get('mark-sheet/unlock', 'School\Controllers\MarkSheetController@unlock');
    Route::post('mark-sheet/save', 'School\Controllers\MarkSheetController@save');

    Route::get('generate-progress', 'School\Controllers\GenerateProgressController@index');
    Route::post('generate-progress/generate-progress-for-all-classes', 'School\Controllers\GenerateProgressController@generateAll');
    Route::get('generate-progress/generate', 'School\Controllers\GenerateProgressController@generate');
    Route::get('generate-progress/re-generate', 'School\Controllers\GenerateProgressController@regenerate');

    Route::get('pdf---hall-ticket', 'reports\School\Controllers\HallTicketController@index');
    Route::get('pdf---hall-ticket/pdf', 'reports\School\Controllers\HallTicketController@report');

    Route::get('pdf---final-progress', 'reports\School\Controllers\FinalProgressController@index');
    Route::get('pdf---final-progress/pdf', 'reports\School\Controllers\FinalProgressController@report');

    Route::get('pdf---student-progress-v1',
        'reports\School\Controllers\ProgressPrintStudentController@index');
    Route::get('pdf---student-progress-v1/pdf',
        'reports\School\Controllers\ProgressPrintStudentController@report');

    Route::get('pdf---student-progress-v2/pdf',
        'reports\School\Controllers\ProgressPrintStudentV2Controller@report');

    Route::get('pdf---class-progress',
        'reports\School\Controllers\ProgressPrintClassController@index');
    Route::get('pdf---class-progress/pdf',
        'reports\School\Controllers\ProgressPrintClassController@report');
    Route::get('pdf---class-progress/csv',
        'reports\School\Controllers\ProgressPrintClassController@csv');


    // Parent Links Group
    Route::get('my-time-table', 'Parent\Controllers\MyTimeTableController@index');
    Route::get('my-attendance', 'Parent\Controllers\MyAttendanceController@index');
    Route::get('my-sms-history', 'Parent\Controllers\MySMSHistoryController@index');
    Route::get('my-student-diary', 'Parent\Controllers\MyStudentDiaryController@index');
    Route::get('my-exam-schedule', 'Parent\Controllers\MyExamScheduleController@index');
    Route::get('my-exam-syllabus', 'Parent\Controllers\MyExamSyllabusController@index');
    Route::get('my-payments', 'Parent\Controllers\MyPaymentsController@index');


    // Sms Links Group
    Route::get('send-sms-v1', 'thirdparty\sms\Controllers\SmsGeneralController@general');
    Route::post('send-sms-v1', 'thirdparty\sms\Controllers\SmsGeneralController@sendGeneral');

    Route::get('send-sms-v2', 'thirdparty\sms\Controllers\SmsGeneralV2Controller@generalV2');
    Route::post('send-sms-v2', 'thirdparty\sms\Controllers\SmsGeneralV2Controller@sendGeneralV2');

    Route::get('send-sms---fee-due', 'thirdparty\sms\Controllers\SmsFeeDueController@feeDue');
    Route::post('send-sms---fee-due', 'thirdparty\sms\Controllers\SmsFeeDueController@sendFeeDue');
    Route::get('send-sms---fee-due/csv', 'thirdparty\sms\Controllers\SmsFeeDueController@feeDueCSV');

    Route::get('send-sms---exam-schedule', 'thirdparty\sms\Controllers\SmsExamScheduleController@examSchedule');
    Route::post('send-sms---exam-schedule', 'thirdparty\sms\Controllers\SmsExamScheduleController@sendExamSchedule');
    Route::get('send-sms---exam-schedule/csv', 'thirdparty\sms\Controllers\SmsExamScheduleController@examScheduleCSV');

    Route::get('send-sms---exam-results', 'thirdparty\sms\Controllers\SmsExamResultsController@examResults');
    Route::post('send-sms---exam-results', 'thirdparty\sms\Controllers\SmsExamResultsController@sendExamResults');
    Route::get('send-sms---exam-results/csv', 'thirdparty\sms\Controllers\SmsExamResultsController@examResultsCSV');

    Route::get('send-sms---attendence', 'thirdparty\sms\Controllers\SmsAttendanceController@attendence');
    Route::post('send-sms---attendence', 'thirdparty\sms\Controllers\SmsAttendanceController@sendAttendance');

    Route::get('send-sms---homework', 'thirdparty\sms\Controllers\SmsHomeworkController@attendence');
    Route::post('send-sms---homework', 'thirdparty\sms\Controllers\SmsHomeworkController@sendHomework');

    Route::get('/sms-batch', 'thirdparty\sms\Controllers\SmsBatchController@smsBatch');
    Route::get('/sms-batch-details', 'thirdparty\sms\Controllers\SmsBatchController@smsBatchDetails');


    // CRM Links Group
    Route::get('client-visit/create', 'CRM\Controllers\ClientVisitController@create');
    Route::post('client-visit/create', 'CRM\Controllers\ClientVisitController@store');
    Route::get('client-visit-details', 'CRM\Controllers\ClientVisitController@detail');
    // Route::get('client-visit/edit/{id}', 'CRM\Controllers\ClientVisitController@edit');
    // Route::post('client-visit/edit/{id}', 'CRM\Controllers\ClientVisitController@update');
    // Route::get('client-visit/delete/{id}', 'CRM\Controllers\ClientVisitController@destroy');

    Route::get('crm-issue', 'CRM\Controllers\CRMIssueController@index');
    Route::get('crm-issue/create', 'CRM\Controllers\CRMIssueController@create');
    Route::post('crm-issue/create', 'CRM\Controllers\CRMIssueController@store');
    Route::get('crm-issue/edit/{id}', 'CRM\Controllers\CRMIssueController@edit');
    Route::post('crm-issue/edit/{id}', 'CRM\Controllers\CRMIssueController@update');
    Route::post('crm-issue/edit/{id}/comment', 'CRM\Controllers\CRMIssueController@comment');

    Route::get('crm-issue-task', 'CRM\Controllers\CRMIssueTaskController@index');
    Route::get('crm-issue-task/create', 'CRM\Controllers\CRMIssueTaskController@create');
    Route::post('crm-issue-task/create', 'CRM\Controllers\CRMIssueTaskController@store');
    Route::get('crm-issue-task/edit/{id}', 'CRM\Controllers\CRMIssueTaskController@edit');
    Route::post('crm-issue-task/edit/{id}', 'CRM\Controllers\CRMIssueTaskController@update');


    // Campaign Links Group
    Route::get('lead---quick-entry', 'Campaign\Controllers\LeadEntryController@index');
    Route::post('lead---quick-entry', 'Campaign\Controllers\LeadEntryController@store');
    Route::post('lead---quick-entry/spreadsheet', 'Campaign\Controllers\LeadEntryController@spreadsheet');


    // Help Links Group
    Route::get('help', 'System\Controllers\HelpController@index');


    // Logout Links Group
    Route::get('/logout', '\App\Http\Controllers\Auth\AuthController@getLogout');


    // Login OTP
    Route::get('otp', 'Admin\Controllers\LoginOTPController@index');
    Route::post('otp', 'Admin\Controllers\LoginOTPController@checkOTP');
    Route::get('otp/resend', 'Admin\Controllers\LoginOTPController@resendOTP');


    // load image for student
    Route::get('/img/student/{id}', '\App\Http\Controllers\ImageController@studentImage');


    // load image for school logo
    Route::get('/img/school-logo/logo.png', '\App\Http\Controllers\ImageController@schoolLogo');


    // make this the last route
    Route::get('/{module}', '\App\Http\Controllers\GridController@index');
});

