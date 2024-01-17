<?php

use App\cities;
use App\cities_code;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ServiceVendorController;
use App\Http\Controllers\AirlinesController;
use App\Http\Controllers\HotelsController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\EscellationsController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityscheduleController;
use App\Http\Controllers\AddonsController;
use App\Http\Controllers\LogViewerController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CronJobController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AirlineRateController;
use App\Http\Controllers\AirportController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\ApprovalGroupController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InquirytypesController;
use App\Http\Controllers\QuotationApprovalController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\SalesreferenceController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\EscalationGroupController;
use App\Http\Controllers\FollowUpTypeController;
use App\Http\Controllers\HotelAjaxController;
use App\Http\Controllers\HotelRateController;
use App\Http\Controllers\LandservicestypesController;
use App\Http\Controllers\MyJobController;
use App\Http\Controllers\OfficeWorkingHourController;
use App\Http\Controllers\OtherServiceController;
use App\Http\Controllers\PerformanceSlabController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\QuotationConversionController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\TeamsJobsController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\VisaRatesController;
use App\Http\Controllers\EscalationController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\Land_services_typesController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Bank_accountsController;
use App\roles;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Auth\Middleware;

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    session()->flash('success', 'System Cache Cleared!');
    return back();
});

Route::get('/', function () {
    return redirect('admin');
})->middleware('auth');

// $role = \App\Role::select('name')->get()->toArray();
//
//Route::group(['middleware' => ['auth', 'roles'],'roles' => $role], function () {
//Route::group(['middleware' => ['role:admin']], function () {
//Route::get('/home', function () {
//
//    //$role = \App\Role::select('name')->get()->toArray();
//    //return $role;exit;
//    if (!auth()->user()->role_id) {
//        echo "Role is not define for current user. Please contact administrator";
//        exit;
//        //Session::flash('message','Role is not define for current user. Please contact administrator');
//        //return redirect('/');
//    }
//    if (auth()->user()->role_id == 1) {
//        echo 'admin';
//        exit;
//        return redirect('admin'); // Admin role
//    } elseif (auth()->user()->role_id == 6) { //sales role
//        echo 'sales';
//        exit;
//        return redirect('sales');
//    }
//});
Route::get('account-settings', 'UsersController@getSettings');
Route::post('account-settings', 'UsersController@saveSettings');

//Route::get('get_inquiry_list', [InquiryController::class, 'get_inquiry_list']);
//Route::get('fetch_data/{page?}', [InquiryController::class, 'fetch_data']);
//Route::get('get_inquiry_remarks/{id?}', [InquiryController::class, 'get_inquiry_remarks']);
//});
// Route::group(['middleware' => ['role:']], function () {
//Core
Route::post('get-cities-by-country', [CustomerController::class, 'getCity']);
// Vendors
Route::get('/login', [SCustomerController::class, 'login']);
Route::get('/vendors', [ServiceVendorController::class, 'index']);
Route::get('/add_vendor_contact_details/{id}', [AjaxController::class, 'add_vendor_contact_details']);
Route::get('/vendors/edit/{id}', [ServiceVendorController::class, 'edit']);
Route::get('/vendors/create', [ServiceVendorController::class, 'create']);
Route::post('/vendors/store', [ServiceVendorController::class, 'store']);
Route::post('/vendors/update', [ServiceVendorController::class, 'update']);
Route::post('/vendors/destroy/{id}', [ServiceVendorController::class, 'destroy']);

// Airlines
Route::get('/airlines', [AirlinesController::class, 'index']);
Route::get('/airlines/edit/{id}', [AirlinesController::class, 'edit']);
Route::get('/airlines/create', [AirlinesController::class, 'create']);
Route::post('/airlines/store', [AirlinesController::class, 'store']);
Route::post('/airlines/update/{id}', [AirlinesController::class, 'update']);
Route::post('/airlines/delete/{id}', [AirlinesController::class, 'destroy']);

// Airline Inv
Route::get('/airlines/inventory/{id}', [AirlinesController::class, 'inventory']);
Route::get('/airlines/inventory/create/{id}', [AirlinesController::class, 'inventory_create']);
Route::post('/airlines/inventory/store/{id}', [AirlinesController::class, 'inventory_store']);
Route::get('/airlines/inventory/edit/{id}/{id_airline}', [AirlinesController::class, 'inventory_edit']);
Route::get('/airlines/inventory/delete/{id}/{id_airline}', [AjaxController::class, 'inventory_delete']);
Route::get('/airlines/inventory/destroy/{id}/{id_airline}', [AirlinesController::class, 'inventory_destroy']);
Route::get('/airlines/get_room_type/{id}', [AjaxController::class, 'get_room_type']);
Route::get('/airlines/get_all_data/{id}', [AirlinesController::class, 'inventory']);
Route::get('/airlines/get_all_data_ajax/{id}', [AjaxController::class, 'inventory']);
Route::post('/airlines/inventory/update/{id}', [AirlinesController::class, 'inventory_update']);
Route::get('/airlines/save_inventory', [AjaxController::class, 'save_inventory'])->name('/airlines/save_inventory');
Route::get('autocomplete_country', [AjaxController::class, 'autocomplete'])->name('autocomplete_country');
Route::get('autocomplete_city', [AjaxController::class, 'autocomplete_city'])->name('autocomplete_city');

// Hotels
Route::get('/hotels', [HotelsController::class, 'index']);
Route::get('/hotels/edit/{id}', [HotelsController::class, 'edit']);
Route::get('/hotels/create', [HotelsController::class, 'create']);
Route::post('/hotels/store', [HotelsController::class, 'store']);
Route::post('/hotels/update/{id}', [HotelsController::class, 'update']);
Route::post('/hotels/delete/{id}', [HotelsController::class, 'destroy']);
Route::get('/hotels/inventory/{id}', [HotelsController::class, 'inventory']);
Route::get('/hotels/inventory/create/{id}', [HotelsController::class, 'inventory_create']);
Route::post('/hotels/inventory/store/{id}', [HotelsController::class, 'inventory_store']);
Route::get('/hotels/inventory/edit/{id}/{id_hotel}', [HotelsController::class, 'inventory_edit']);
Route::get('/hotels/inventory/delete/{id}/{id_hotel}', [HotelAjaxController::class, 'inventory_delete']);
Route::get('/hotels/inventory/destroy/{id}/{id_hotel}', [HotelsController::class, 'inventory_destroy']);
Route::get('/get_room_type/{id}', [HotelAjaxController::class, 'get_room_type']);
Route::get('/get_all_data/{id}', [HotelAjaxController::class, 'inventory']);
Route::post('/hotels/inventory/update/{id}', [HotelsController::class, 'inventory_update']);
Route::get('/save_inventory', [HotelAjaxController::class, 'save_inventory'])->name('/save_inventory');

// Packages
Route::get('/packages', [PackagesController::class, 'index']);
Route::get('/packages/edit/{id}', [PackagesController::class, 'edit']);
Route::get('/packages/create', [PackagesController::class, 'create']);
Route::post('/packages/store', [PackagesController::class, 'store']);
Route::post('/packages/update/{id}', [PackagesController::class, 'update']);
Route::post('/packages/delete/{id}', [PackagesController::class, 'destroy']);

// package_types
Route::get('/package_types', [PackagesController::class, 'package_types_index']);
Route::get('/package_types/edit/{id}', [PackagesController::class, 'package_types_edit']);
Route::get('/package_types/create', [PackagesController::class, 'package_types_create']);
Route::post('/package_types/store', [PackagesController::class, 'package_types_store']);
Route::post('/package_types/update/{id}', [PackagesController::class, 'package_types_update']);
Route::post('/package_types/delete/{id}', [PackagesController::class, 'package_types_destroy']);

// Inquiry Types
Route::get('/inquiry', [InquiryController::class, 'get_inquiry_list']);
Route::get('/get_followup_details/{id}', [AjaxController::class, 'get_followup_details']);
Route::get('/inquiry_edit/{inquiry_id}', [InquiryController::class, 'edit_inquiry_index']);
Route::get('/inquiry_ajax_list', [InquiryController::class, 'getdata']);
Route::get('/inquiry/create', [InquiryController::class, 'create']);
Route::post('/inquiry/store', [InquiryController::class, 'store']);
Route::post('add_inquiry_remarks', [InquiryController::class, 'add_inquiry_remarks']);
Route::post('add_followup_remarks', [InquiryController::class, 'add_followup_remarks']);
Route::post('inquiry_edit_update', [InquiryController::class, 'inquiry_edit_update']);
Route::get('append_services_edit/{inq_id}', [InquiryController::class, 'append_services_edit']);
Route::get('/edit_inquiry/{id}', 'InquiryController@edit')->name('edit_inquiry');
Route::post('/update_inquiry/{id}', 'InquiryController@update')->name('update_inquiry');
Route::get('/delete_inquiry/{id}', 'InquiryController@destroy')->name('delete_inquiry');
Route::get('/get_sub_services/{id}', 'AjaxController@get_sub_services')->name('get_sub_services');
Route::get('/get_sub_services_id/{id}/{inq_id}', 'AjaxController@get_sub_services_id');
Route::get('/add_more_services/{count}', 'AjaxController@add_more_services')->name('add_more_services');
Route::get('/add_more_services_users/{count}', 'AjaxController@add_more_services_users')->name('add_more_services_users');
Route::get('/get_campaign_data/{id}', 'AjaxController@get_campaign_data')->name('get_campaign_data');

Route::get('/followups', [MyJobController::class, 'followups']);

// Inquiry Types
Route::get('/inquiry_types', [InquirytypesController::class, 'index']);
Route::get('/inquiry_types/edit/{id}', [InquirytypesController::class, 'edit']);
Route::get('/inquiry_types/create', [InquirytypesController::class, 'create']);
Route::post('/inquiry_types/store', [InquirytypesController::class, 'store']);
Route::post('/inquiry_types/update/{id}', [InquirytypesController::class, 'update']);
Route::post('/inquiry_types/delete/{id}', [InquirytypesController::class, 'destroy']);

//Notifications Crud
Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index']);
Route::get('/team_notifications', [App\Http\Controllers\NotificationController::class, 'team_index']);
Route::get('/escalation_notifications', [App\Http\Controllers\NotificationController::class, 'escalation_index']);
Route::get('/get_escalations_data', [AjaxController::class, 'get_escalations_data']);
Route::get('/issuance_notifications', [App\Http\Controllers\NotificationController::class, 'issuance_index']);
Route::get('/approval_notifications', [App\Http\Controllers\NotificationController::class, 'approval_index']);
// Notifcation Work for My Jobs
Route::get('get_notifications_my_jobs', [App\Http\Controllers\NotificationController::class, 'get_notifications_my_jobs']);
Route::get('get_noti_count_my_jobs/{count?}', [App\Http\Controllers\NotificationController::class, 'get_noti_count_my_jobs']);
Route::get('notification_read_my_jobs/{id}', [App\Http\Controllers\NotificationController::class, 'notification_read_my_jobs']);
Route::get('get_notifications_data', 'AjaxController@getnotificationsData')->name('get_notifications_data');

// Paymennts Notification
Route::get('get_notifications_payments', [App\Http\Controllers\NotificationController::class, 'get_notifications_payments']);
Route::get('get_noti_count_payments/{count?}', [App\Http\Controllers\NotificationController::class, 'get_noti_count_payments']);
Route::get('notification_read_payments/{id}', [App\Http\Controllers\NotificationController::class, 'notification_read_payments']);
// General Notification
Route::get('get_notifications_general', [NotificationController::class, 'get_notifications_general']);
Route::get('get_noti_count_general/{count?}', [NotificationController::class, 'get_noti_count_general']);
Route::get('notification_read_general/{id}', [NotificationController::class, 'notification_read_general']);

Route::get('get_notifications_team', [NotificationController::class, 'get_notifications_team']);
Route::get('get_noti_count_team/{count?}', [NotificationController::class, 'get_noti_count_team']);
Route::get('notification_read_team/{id}', [NotificationController::class, 'notification_read_team']);
Route::get('get_team_notifications_data', 'AjaxController@getteamnotificationsData')->name('get_team_notifications_data');

// Escalation Notification
Route::get('get_escalations', [NotificationController::class, 'get_escalations']);
Route::get('get_escalations_count/{count?}', [NotificationController::class, 'get_escalations_count']);
Route::get('escalations_read/{id}', [NotificationController::class, 'escalations_read']);
Route::get('/escalation_preferences', [EscalationController::class, 'preferences']);


// Quoatation Approval notifications
Route::get('get_approval_data', 'AjaxController@getapprovalData')->name('get_approval_data');
Route::get('get_approvals', [NotificationController::class, 'get_approvals']);
Route::get('get_approvals_count/{count?}', [NotificationController::class, 'get_approvals_count']);
Route::get('get_approvals_read/{id}', [NotificationController::class, 'get_approvals_read']);

// Quoatation Issuance notifications
Route::get('get_issuance_data', 'AjaxController@getissuanceData')->name('get_issuance_data');
Route::get('get_issuance', [NotificationController::class, 'get_issuance']);
Route::get('get_issuance_count/{count?}', [NotificationController::class, 'get_issuance_count']);
Route::get('get_issuance_read/{id}', [NotificationController::class, 'get_issuance_read']);



Route::get('send_noti_test', [NotificationController::class, 'test']);

// Security For Lock Screen

Route::get('lock_screen_auto/{type}', [App\Http\Controllers\SecurityController::class, 'lock_screen_auto']);
Route::post('check_pincode', [App\Http\Controllers\SecurityController::class, 'check_pincode']);

// Customer Work

Route::get('customers', [CustomerController::class, 'index']);
Route::get('customers/create', [CustomerController::class, 'create']);
Route::post('customers/store', [CustomerController::class, 'store']);
Route::get('get-data', [AjaxController::class, 'getData']);
Route::get('get_customer_details', [AjaxController::class, 'get_customer_details']);
Route::get('check_customer_number/{cell}', [AjaxController::class, 'check_customer_number']);
Route::get('customer_list/{query?}', [AjaxController::class, 'customer_search']);
Route::get('customers/destroy/{id}', [CustomerController::class, 'destroy']);
Route::get('customers/edit/{id}', [CustomerController::class, 'edit']);
Route::get('customers/update/{id}', [CustomerController::class, 'update']);

// Sale References
Route::get('/sales_references', [SalesreferenceController::class, 'index']);
Route::get('/sales_references/edit/{id}', [SalesreferenceController::class, 'edit']);
Route::get('/sales_references/create', [SalesreferenceController::class, 'create']);
Route::post('/sales_references/store', [SalesreferenceController::class, 'store']);
Route::post('/sales_references/update/{id}', [SalesreferenceController::class, 'update']);
Route::post('/sales_references/delete/{id}', [SalesreferenceController::class, 'destroy']);

// Departmetns
Route::get('/departments', [DepartmentsController::class, 'index']);
Route::get('/departments/edit/{id}', [DepartmentsController::class, 'edit']);
Route::get('/departments/create', [DepartmentsController::class, 'create']);
Route::post('/departments/store', [DepartmentsController::class, 'store']);
Route::post('/departments/update/{id}', [DepartmentsController::class, 'update']);
Route::post('/departments/delete/{id}', [DepartmentsController::class, 'destroy']);
Route::get('/remove_department_user/{u_id}/{d_id}', [DepartmentsController::class, 'remove_department_user']);
Route::post('/assign_user_teams', [DepartmentsController::class, 'assign_user_teams']);
Route::post('/assign_services_department', [DepartmentsController::class, 'assign_services_department']);
Route::post('/add_department_teams', [DepartmentsController::class, 'add_department_teams']);
Route::GET('/get_department_users/{dep_id}', [AjaxController::class, 'get_department_users']);

// escellations
Route::get('/escellations', [EscellationsController::class, 'index']);
Route::get('/escellations/edit/{id}', [EscellationsController::class, 'edit']);
Route::get('/escellations/create', [EscellationsController::class, 'create']);
Route::post('/escellations/store', [EscellationsController::class, 'store']);
Route::post('/escellations/update/{id}', [EscellationsController::class, 'update']);
Route::post('/escellations/delete/{id}', [EscellationsController::class, 'destroy']);

// Jobs
Route::get('/jobs', [JobsController::class, 'index']);
Route::get('/jobs/edit/{id}', [JobsController::class, 'edit']);
Route::get('/jobs/create', [JobsController::class, 'create']);
Route::post('/jobs/store', [JobsController::class, 'store']);
Route::post('/jobs/update/{id}', [JobsController::class, 'update']);
Route::post('/jobs/delete/{id}', [JobsController::class, 'destroy']);

//Users Routes
Route::get('users', [UsersController::class, 'index']);
Route::get('users/create', [UsersController::class, 'create']);
Route::post('users/store', [UsersController::class, 'store']);
Route::get('users/edit/{id}', [UsersController::class, 'edit']);
Route::post('users/update/{id}', [UsersController::class, 'update']);
Route::get('my_profile', [UsersController::class, 'profile_index']);

//Roles
Route::get('/roles', [RoleController::class, 'index']);
Route::get('/roles/add', [RoleController::class, 'create']);
Route::post('/roles/store/', [RoleController::class, 'store']);
Route::get('/roles/edit/{id}', [RoleController::class, 'edit']);
Route::post('/roles/edit/{id}', [RoleController::class, 'update']);
Route::post('/roles/delete', [RoleController::class, 'destroy']);

//Cities
Route::get('/cities', [CityController::class, 'index']);
Route::get('/city/create', [CityController::class, 'city/create']);
Route::get('get_cities_data', 'AjaxController@getCitiesData')->name('get_cities_data');
Route::post('/city/store', [CityController::class, 'city/store']);
Route::get('/city/edit/{id}', [CityController::class, 'city/edit']);
Route::put('/city/edit/{id}', [CityController::class, 'city/update']);

//Countries
Route::get('/countries', [CountryController::class, 'index']);
Route::get('countries/create', [CountryController::class, 'create']);

//Admin Controller
Route::get('admin', [AdminController::class, 'index']);
Route::post('addTask', [AdminController::class, 'addTask']);
Route::post('deleteTask', [AdminController::class, 'deleteTask']);
Route::get('viewTask/{id}', [AdminController::class, 'viewTask']);

//Admin Controller
Route::get('sales', [SalesController::class, 'index']);
Route::post('addTask', [SalesController::class, 'addTask']);
Route::post('deleteTask', [SalesController::class, 'deleteTask']);
Route::get('viewTask/{id}', [SalesController::class, 'viewTask']);

//Permission management
Route::get('permission-management', [PermissionController::class, 'index']);
Route::get('permission/create', [PermissionController::class, 'create']);
Route::post('permission/create', [PermissionController::class, 'save']);
Route::get('permission/delete/{id}', [PermissionController::class, 'delete']);
Route::get('permission/edit/{id}', [PermissionController::class, 'edit']);
Route::post('permission/edit/{id}', [PermissionController::class, 'update']);

//Activity log
Route::get('activity-log', [LogViewerController::class, 'getActivityLog']);
Route::get('activity-log/data', [LogViewerController::class, 'data']);

//Log Viewer
//    Route::get('log-viewers', [\Arcanedev\LogViewer\Http\Controllers\LogViewerController@index::class, 'log-viewers']);
//    Route::get('log-viewers/logs', [\Arcanedev\LogViewer\Http\Controllers\LogViewerController@listLogs::class, 'log-viewers.logs']);
//    Route::delete('log-viewers/logs/delete', [\Arcanedev\LogViewer\Http\Controllers\LogViewerController@delete::class, 'log-viewers.logs.delete']);
//    Route::get('log-viewers/logs/{date}', [\Arcanedev\LogViewer\Http\Controllers\LogViewerController@show::class, 'log-viewers.logs.show']);
//    Route::get('log-viewers/logs/{date}/download', [\Arcanedev\LogViewer\Http\Controllers\LogViewerController@download::class, 'log-viewers.logs.download']);
//    Route::get('log-viewers/logs/{date}/{level}', [\Arcanedev\LogViewer\Http\Controllers\LogViewerController@showByLevel::class, 'log-viewers.logs.filter']);
//    Route::get('log-viewers/logs/{date}/{level}/search', [\Arcanedev\LogViewer\Http\Controllers\LogViewerController@search::class, 'log-viewers.logs.search']);
//    Route::get('log-viewers/logcheck', [\Arcanedev\LogViewer\Http\Controllers\LogViewerController@logCheck::class, 'log-viewers.logcheck']);
// Cost Center Routes
//    Route::get('/cost_center', [CostCenterController@index::class, 'cost_center']);
//    Route::get('/create_cost_center', [CostCenterController@create::class, 'create_cost_center']);
//    Route::post('/store_cost_center', [CostCenterController@store::class, 'store_cost_center']);
//    Route::get('/edit_cost_center/{id}', [CostCenterController@edit::class, 'edit_cost_center']);
//    Route::post('/update_cost_center/{id}', [CostCenterController@update::class, 'update_cost_center']);
//    Route::get('/delete_cost_center/{id}', [CostCenterController@destroy::class, 'delete_cost_center']);
// Activity Routes
Route::get('/activity', [ActivityController::class, 'index']);
Route::get('/create_activity', [ActivityController::class, 'create']);
Route::post('/store_activity', [ActivityController::class, 'store']);
Route::get('/edit_activity/{id}', [ActivityController::class, 'edit']);
Route::post('/update_activity/{id}', [ActivityController::class, 'update']);
Route::get('/delete_activity/{id}', [ActivityController::class, 'destroy']);

//Activity schedule routes
Route::get('/activity/schedule', [ActivityscheduleController::class, 'trainings/schedule']);
Route::get('/activity/schedule/create/{id}', [ActivityscheduleController::class, 'trainings/schedule/create']);
Route::post('/activity/schedule/store', [ActivityscheduleController::class, 'trainings/schedule/store']);
Route::post('/activity/getCustomersBySaleman', [ActivityscheduleController::class, 'activity/getCustomersBySaleman']);
Route::post('/activity/schedule/data', [ActivityscheduleController::class, 'activity/schedule/data']);
Route::post('/activity/schedule/update/time', [ActivityscheduleController::class, 'activity/schedule/update/time']);
Route::post('/activity/schedule/update/date', [ActivityscheduleController::class, 'activity/schedule/update/date']);
Route::post('/activity/schedule/edit/status/{id}', [ActivityscheduleController::class, 'activity/schedule/edit/status']);
Route::put('/activity/schedule/edit/status', [ActivityscheduleController::class, 'activity/schedule/edit/status']);
Route::post('/activity/schedule/comments', [ActivityscheduleController::class, 'activity/schedule/comments']);
Route::post('/activity/schedule/comments/insert', [ActivityscheduleController::class, 'activity/schedule/comments/insert']);
Route::post('/activity/schedule/edit', [ActivityscheduleController::class, 'activity/schedule/edit']);
Route::put('/activity/schedule/edit', [ActivityscheduleController::class, 'activity/schedule/edit']);

//FileUpload & Attachments
Route::get('/fileupload', [FileUploadController::class, 'index']);
Route::post('/fileupload', [FileUploadController::class, 'index']);
Route::get('/create_fileupload', [FileUploadController::class, 'create']);
Route::post('/create_fileupload', [FileUploadController::class, 'store']);
Route::get('/viewfileupload', [FileUploadController::class, 'viewFile']);
Route::get('/delete_file_upload/{id}', [FileUploadController::class, 'destroy']);
Route::post('/sharedwith', [FileUploadController::class, 'sharedwith']);
Route::post('/getusersforupload', [FileUploadController::class, 'getusers']);
Route::get('/sharedwithmelist', [FileUploadController::class, 'sharedwithmelist']);
Route::get('/sharewithmeview/{fileid}', [FileUploadController::class, 'sharewithmeview']);

//Permission
Route::get('/roles/permission/{id}', [PermissionController::class, 'index']);
Route::post('/roles/permission/{id}', [PermissionController::class, 'store']);


Route::get('logout', [LoginController::class, 'logout']);
Route::get('cronjob', [CronJobController::class, 'run']);



// Office Working Hour
Route::get('/office_working_hours', [OfficeWorkingHourController::class, 'index']);
Route::get('/office_working_hours/edit/{id}', [OfficeWorkingHourController::class, 'edit']);
Route::get('/office_working_hours/create', [OfficeWorkingHourController::class, 'create']);
Route::post('/office_working_hours/store', [OfficeWorkingHourController::class, 'store']);
Route::post('/office_working_hours/update/{id}', [OfficeWorkingHourController::class, 'update']);
Route::post('/office_working_hours/delete/{id}', [OfficeWorkingHourController::class, 'destroy']);

// Follow Up TYpes
Route::get('/follow_up_types', [FollowUpTypeController::class, 'index']);
Route::get('/follow_up_types/edit/{id}', [FollowUpTypeController::class, 'edit']);
Route::get('/follow_up_types/create', [FollowUpTypeController::class, 'create']);
Route::post('/follow_up_types/store', [FollowUpTypeController::class, 'store']);
Route::post('/follow_up_types/update/{id}', [FollowUpTypeController::class, 'update']);
Route::post('/follow_up_types/delete/{id}', [FollowUpTypeController::class, 'destroy']);
// Performance Slabs
Route::get('/performance_slabs', [PerformanceSlabController::class, 'index']);
Route::get('/performance_slabs/edit/{id}', [PerformanceSlabController::class, 'edit']);
Route::get('/performance_slabs/create', [PerformanceSlabController::class, 'create']);
Route::post('/performance_slabs/store', [PerformanceSlabController::class, 'store']);
Route::post('/performance_slabs/update/{id}', [PerformanceSlabController::class, 'update']);
Route::post('/performance_slabs/delete/{id}', [PerformanceSlabController::class, 'destroy']);
// Other Serviees
Route::get('/other_services', [OtherServiceController::class, 'index']);
Route::get('/other_services/edit/{id}', [OtherServiceController::class, 'edit']);
Route::get('/other_services/create', [OtherServiceController::class, 'create']);
Route::post('/other_services/store', [OtherServiceController::class, 'store']);
Route::post('/other_services/update/{id}', [OtherServiceController::class, 'update']);
Route::post('/other_services/delete/{id}', [OtherServiceController::class, 'destroy']);
// Airport
Route::get('/airports', [AirportController::class, 'index']);
Route::get('/airports/edit/{id}', [AirportController::class, 'edit']);
Route::get('/airports/create', [AirportController::class, 'create']);
Route::post('/airports/store', [AirportController::class, 'store']);
Route::post('/airports/update/{id}', [AirportController::class, 'update']);
Route::post('/airports/delete/{id}', [AirportController::class, 'destroy']);

// Room TYpes
Route::get('/room_types', [RoomTypeController::class, 'index']);
Route::get('/room_types/edit/{id}', [RoomTypeController::class, 'edit']);
Route::get('/room_types/create', [RoomTypeController::class, 'create']);
Route::post('/room_types/store', [RoomTypeController::class, 'store']);
Route::post('/room_types/update/{id}', [RoomTypeController::class, 'update']);
Route::post('/room_types/delete/{id}', [RoomTypeController::class, 'destroy']);

// hotel Rates
Route::get('/hotels/hotel_rates/{hotel_id}', [HotelRateController::class, 'index']);
Route::get('/hotel_rates/edit/{id}', [HotelRateController::class, 'edit']);
Route::get('/hotel_rates/create/{hotel_id}', [HotelRateController::class, 'create']);
Route::post('/hotel_rates/store', [HotelRateController::class, 'store']);
Route::post('/hotel_rates/update/{id}', [HotelRateController::class, 'update']);
Route::get('/hotel_rates/delete/{id}', [HotelRateController::class, 'destroy']);
Route::get('/get_hotel_rates/{hotel_id}/{count}/{room_type}', [AjaxController::class, 'get_hotel_rates']);
Route::get('/add_hotel_rates/{hotel_rate_id}', [AjaxController::class, 'add_hotel_rates']);
// Airline  Rates
Route::get('/airline/airline_rates/{airline_id}', [AirlineRateController::class, 'index']);
Route::get('/airline_rates/edit/{id}', [AirlineRateController::class, 'edit']);
Route::get('/airline_rates/create/{airline_id}', [AirlineRateController::class, 'create']);
Route::post('/airline_rates/store', [AirlineRateController::class, 'store']);
Route::post('/airline_rates/update/{id}', [AirlineRateController::class, 'update']);
Route::get('/airline_rates/delete/{id}', [AirlineRateController::class, 'destroy']);
Route::get('/get_airline_rates/{count}', [AjaxController::class, 'get_airline_rates']);
Route::get('/add_airline_rates/{airline_rate_id}', [AjaxController::class, 'add_airline_rates']);

// Camapaign
Route::get('/campaigns', [CampaignController::class, 'index']);
Route::get('/campaigns/edit/{id}', [CampaignController::class, 'edit']);
Route::get('/campaigns/create', [CampaignController::class, 'create']);
Route::post('/campaigns/store', [CampaignController::class, 'store']);
Route::post('/campaigns/update/{id}', [CampaignController::class, 'update']);
Route::get('/campaigns/delete/{id}', [CampaignController::class, 'destroy']);
// Approval Group
Route::get('/approval_group', [ApprovalGroupController::class, 'index']);
Route::get('/approval_group/edit/{id}', [ApprovalGroupController::class, 'edit']);
Route::get('/approval_group/create', [ApprovalGroupController::class, 'create']);
Route::post('/approval_group/store', [ApprovalGroupController::class, 'store']);
Route::post('/approval_group/update/{id}', [ApprovalGroupController::class, 'update']);
Route::get('/approval_group/delete/{id}', [ApprovalGroupController::class, 'destroy']);
// Excilation Group
Route::get('/escalation_group', [EscalationGroupController::class, 'index']);
Route::get('/escalation_group/edit/{id}', [EscalationGroupController::class, 'edit']);
Route::get('/escalation_group/create', [EscalationGroupController::class, 'create']);
Route::post('/escalation_group/store', [EscalationGroupController::class, 'store']);
Route::post('/escalation_group/update/{id}', [EscalationGroupController::class, 'update']);
Route::get('/escalation_group/delete/{id}', [EscalationGroupController::class, 'destroy']);
// My Teams Jobs
Route::get('/my_teams_jobs', [TeamsJobsController::class, 'index']);
Route::post('/take_my_team_job', [TeamsJobsController::class, 'take_my_team_job']);
Route::post('/assign_my_team_job', [TeamsJobsController::class, 'assign_my_team_job']);
// My  Jobs
Route::get('/my_jobs', [MyJobController::class, 'index']);
Route::get('/my_jobs/create/{inq_id}/{team_id}', [MyJobController::class, 'create']);
Route::post('/assign_job', [MyJobController::class, 'assign_job']);
// Accounts
// Route::get('/quotation_invoices', [AccountsController::class, 'index']);
Route::get('/payment_invoice_list', [AccountsController::class, 'payment_invoice_list']);
Route::get('/pending_payment_list', [AccountsController::class, 'pending_payment_list']);
Route::get('/cheque_list', [AccountsController::class, 'cheque_list']);
Route::get('/roe_difference_list', [AccountsController::class, 'roe_difference_list']);
Route::get('/accounts_issuance_list', [AccountsController::class, 'accounts_issuance_list']);
Route::get('/get_pay_quotation_details/{q_id}', [AjaxController::class, 'get_pay_quotation_details']);
Route::get('/onchange_amount_val/{q_id}', [AjaxController::class, 'onchange_amount_val']);
// Quotations
Route::get('/create_quotation/{id}', [QuotationController::class, 'create_quotation']);
Route::get('/edit_quotation/{id}', [QuotationController::class, 'edit_quotation']);
Route::get('/get_hotel_city_category/{city}/{cat}', [AjaxController::class, 'get_hotel_city_category']);

Route::post('/create_quotation/{id}', [QuotationController::class, 'store']);
Route::get('/view_quotation/{uniq_id}/{inq_id}', [QuotationController::class, 'view_quotation']);
Route::get('/view_voucher/{uniq_id}/{inq_id}', [QuotationController::class, 'view_vouchers']);
Route::get('/create_service_voucher/{q_id}', [QuotationApprovalController::class, 'create_voucher']);
// Route::post('/create_quotation_store', [QuotationController::class, 'store']);
Route::get('/get_inv_details/{inv_id}', [QuotationController::class, 'get_inv_details']);
Route::get('/add_airline_inventory/{inv_id}', [QuotationController::class, 'add_airline_inventory']);
Route::get('/get_airline_flight_class/{inv_id}/{flight_class}', [QuotationController::class, 'get_airline_flight_class']);
Route::post('/change_quote_status', [QuotationController::class, 'change_quote_status']);
Route::get('/add_airline_destination/{append_count}/{legs_count}', [QuotationController::class, 'add_airline_destination']);
Route::get('/add_hotel_legs/{append_count}/{legs_count}/{sub_services}/{addon_count}/{service_type}', [QuotationController::class, 'add_hotel_legs']);
Route::get('/get_inv_details_fill_price/{inv_id}/{room_type}', [QuotationController::class, 'get_inv_details_fill_price']);
Route::get('/append_quotation_details/{sub_services}/{append_count}/{service_type}/{legs_count}/{inq_id}', [QuotationController::class, 'append_quotation_details']);
Route::get('/get_inquiry_from_id/{inq_id}', [AjaxController::class, 'get_inquiry_from_id']);
Route::get('/get_package_from_sub_services/{services_id}/{inquiry_id}/{count}', [AjaxController::class, 'get_package_from_sub_services']);
Route::get('/get_quotations_sub_services/{sub_services_id}/{services_id}/{inquiry_id}/{count}', [AjaxController::class, 'get_quotations_sub_services']);
Route::get('/get_room_types_hotel_inv/{hotel_inv}', [AjaxController::class, 'get_room_types_hotel_inv']);
Route::get('/get_hotel_inv_details/{hotel_inv}/{room_type_id}', [AjaxController::class, 'get_hotel_inv_details']);
Route::get('/get_hotel_inv_details/{hotel_inv}/{room_type_id}', [AjaxController::class, 'get_hotel_inv_details']);
Route::get('/append_hotel_beds/{hotel_room_type}/{append_count}', [AjaxController::class, 'append_hotel_beds']);
// get inventory
Route::get('/get_inventory_details_airline/{airline_id}/{append_count}/{inq_id}', [AjaxController::class, 'get_inventory_details_airline']);
Route::get('/get_inventory_details_hotel/{hotel_id}/{append_count}/{inq_id}', [AjaxController::class, 'get_inventory_details_hotel']);
Route::get('/get_hotel_available_rooms/{hotel_id}/{append_count}/{inq_id}', [AjaxController::class, 'get_hotel_available_rooms']);
Route::get('/add_airline_inv_details/{inv_id}/{append_count}', [AjaxController::class, 'add_airline_inv_details']);
Route::get('/add_hotel_inv_details/{inv_id}/{append_count}', [AjaxController::class, 'add_hotel_inv_details']);
Route::get('/get_addons/{array_ids}', [AjaxController::class, 'get_addons']);
// Land Services Quotation
Route::get('/get_land_service_routes/{id}', [AjaxController::class, 'get_land_service_routes']);
Route::get('/get_route_details/{l_id}/{id}/{service_type}', [AjaxController::class, 'get_route_details']);
Route::get('/add_land_services_legs/{append_count}/{legs_count}/{sub_services}/{addon_count}', [QuotationController::class, 'add_land_services_legs']);

// Parsing Ajax
Route::get('/parsing_details/{append_count}', [AjaxController::class, 'parsing_details']);
Route::get('/get_team_users/{id}', [AjaxController::class, 'get_team_users']);
// Route::get('/update_DB', function () {
//     $get_cities = cities::all();
//     foreach ($get_cities as $i) {
//         $get_ci = cities_code::where('name', $i->name)->first();
//         dd($get_ci);
//     }
// });

// Route::get('/change_flight_class/{airline_inv_id}/{flight_class}', [AjaxController::class, 'change_flight_class']);



//});

Auth::routes();

// Addons Route
Route::get('/addons', [AddonsController::class, 'index']);
Route::get('/addons/create', [AddonsController::class, 'create']);
Route::post('/addons/store', [AddonsController::class, 'store']);
Route::get('/addons/edit/{id}', [AddonsController::class, 'edit']);
Route::post('/addons/update/{id}', [AddonsController::class, 'update']);
//currency Exchange
Route::get('/currency_exchange', [CurrencyController::class, 'index']);
Route::get('/currency_exchange/create', [CurrencyController::class, 'create']);
Route::post('/currency_exchange/store', [CurrencyController::class, 'store']);
Route::get('/currency_exchange/edit/{id}', [CurrencyController::class, 'edit']);
Route::post('/currency_exchange/update/{id}', [CurrencyController::class, 'update']);

// My Bank Account Route Start
Route::get('/my_bank_accounts', [Bank_accountsController::class, 'index']);
Route::get('/my_bank_accounts/create', [Bank_accountsController::class, 'create']);
Route::post('/my_bank_accounts/store', [Bank_accountsController::class, 'store']);
Route::get('/my_bank_accounts/edit/{id}', [Bank_accountsController::class, 'edit']);
Route::post('/my_bank_accounts/update/{id}', [Bank_accountsController::class, 'update']);

// My Bank Account Route End

//land_and_services_types
Route::get('/land_services', [LandservicestypesController::class, 'index']);
Route::get('/land_services/create', [LandservicestypesController::class, 'create']);
Route::post('/land_services/store', [LandservicestypesController::class, 'store']);
Route::get('/land_services/edit/{id}', [LandservicestypesController::class, 'edit']);
Route::post('/land_services/update/{id}', [LandservicestypesController::class, 'update']);
Route::get('/add_land_services_details/{add_more_services_id}',  [AjaxController::class, 'add_land_services']);

//land_services_types
Route::get('/land_services_types', [Land_services_typesController::class, 'index']);
Route::get('/land_services_types/create', [Land_services_typesController::class, 'create']);
Route::post('/land_services_types/store', [Land_services_typesController::class, 'store']);
Route::get('/land_services_types/edit/{id}', [Land_services_typesController::class, 'edit']);
Route::post('/land_services_types/update/{id}', [Land_services_typesController::class, 'update']);

// Add Land Service Type Modal
Route::post('/add_land_service_type', [LandservicestypesController::class, 'add_land_service_type']);
Route::get('/append_land_services/{v_id}', [LandservicestypesController::class, 'append_land_services']);
// End Add Land Service Type Modal
//Route
Route::get('/route', [RouteController::class, 'index'])->name('route.index');
Route::get('/route/create', [RouteController::class, 'create']);
Route::post('/route/store', [RouteController::class, 'store']);
Route::get('/route/edit/{id}', [RouteController::class, 'edit'])->name('route.edit');
Route::post('/route/update/{id}', [RouteController::class, 'update']);
Route::get('add_route_details/{add_more_route_id}', [AjaxController::class, 'add_more_route_fun']);
Route::get('add_land_services_routes_legs/{route}/{transport}/{land_service}/{append_count}/{land_sl_count}', [AjaxController::class, 'add_land_services_routes_legs']);


// Visa Rates Route
Route::get('/visa_rate', [VisaRatesController::class, 'index']);
Route::get('/visa_rate/create', [VisaRatesController::class, 'create']);
Route::post('/visa_rate/store', [VisaRatesController::class, 'store']);
Route::get('/visa_rate/edit/{id}', [VisaRatesController::class, 'edit']);
Route::post('/visa_rate/update', [VisaRatesController::class, 'update']);


Route::get('get_visa_rates/{id}', [AjaxController::class, 'get_visa_rates']);

// Quotation Conersion
Route::get('edit_quotation/{inq_id}/{q_id}/{type}', [QuotationConversionController::class, 'edit_quotation']);
Route::get('edit_quotation_original/{inq_id}/{q_id}/{type}', [QuotationConversionController::class, 'edit_quotation_original']);
Route::get('/append_quotation_details_for_edit/{sub_services}/{append_count}/{service_type}/{legs_count}/{inq_id}/{q_id}', [QuotationConversionController::class, 'append_quotation_details']);
Route::post('/create_quotation/conversion/{id}', [QuotationConversionController::class, 'store']);

// Escalation Work
Route::get('/escalation_timer_for_not_assign', [EscalationController::class, 'escalation_timer_for_not_assign']);
Route::get('/escalation_timer_for_open', [EscalationController::class, 'escalation_timer_for_open']);

// Send Quotation To Approval
Route::get('/send_quotation_to_approval/{q_id}/{inq_id}', [AjaxController::class, 'send_quotation_to_approval']);
Route::get('/send_quotation_to_issuance/{q_id}/{inq_id}/{services_type}', [AjaxController::class, 'send_quotation_to_issuance']);

// Quotation Approvals And Issuance
Route::get('/quotation_approvals', [QuotationApprovalController::class, 'index']);
Route::get('/get_quotation_approvals_data', [AjaxController::class, 'get_quotation_approvals_data']);
Route::get('/quotation_approved/{quotation_id}/{inquiry_id}', [QuotationApprovalController::class, 'quotation_approved']);
Route::get('/quotation_disapproved/{quotation_id}/{inquiry_id}', [QuotationApprovalController::class, 'quotation_disapproved']);
Route::get('/reject_issuance/{quote_id}/{inq_id}/{type}/{hotel_legs?}', [QuotationApprovalController::class, 'reject_issuance']);
Route::get('/take_quotation_issuance/{q_id}/{assuance_id}', [QuotationApprovalController::class, 'take_quotation_issuance']);
Route::get('/issuance_verification/{inq_id}/{quote_id}', [QuotationApprovalController::class, 'issuance_verification']);
Route::get('/send_issuance_for_verification/{vendor}/{quote_id}/{inq_id}/{type}/{hotel_legs?}', [QuotationApprovalController::class, 'send_issuance_for_verification']);


Route::get('/view_quotation_of_verification/{uniq_id}/{inq_id}/{services_type}', [QuotationApprovalController::class, 'view_quotation_of_verification']);
Route::post('/submit_issuance_details', [QuotationApprovalController::class, 'submit_issuance_details']);

// Doucmentation
Route::post('/add_documentation', [DocumentationController::class, 'add_documentation']);
// Payments Quotation
Route::post('/pay_quotation_amount', [PaymentController::class, 'pay_quotation_amount']);
// Account Payment
Route::get('/view_invoice_payment_details/{id}', [AjaxController::class, 'view_invoice_payment_details']);
Route::post('/update_receiving_number', [AccountsController::class, 'update_receiving_number']);

// Update Quotation Cost Price Of Sale Person
// Route::get('/update_cost_price_sale_person', [QuotationApprovalController::class, 'update_cost_price_sale_person']);
Route::post('/update_cost_price_sale_person', [QuotationApprovalController::class, 'update_cost_price_sale_person']);
Route::post('/update_cost_price_sale_person', [QuotationApprovalController::class, 'update_cost_price_sale_person']);

// Customer Verification
Route::get('/customer_verification/{q_id}', [QuotationApprovalController::class, 'customer_verification']);

