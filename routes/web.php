<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CallHistoryController;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\SalesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect(route('login'));
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


Route::get('/show_employee', [EmployeeController::class, 'showEmployees'])->name('show_employee');
Route::get('/employee_detail', [EmployeeController::class, 'employeeDetail'])->name('employee_detail');
Route::post('/add_employee', [EmployeeController::class, 'createEmployee'])->name('employees.store');
Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
Route::post('/employees/{id}/update', [EmployeeController::class, 'update'])->name('employees.update');
Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
Route::get('/employees/{id}/toggle', [EmployeeController::class, 'toggleActive'])->name('employees.toggle');




Route::get('/call_history',[CallHistoryController::class, 'filterCallHistoryByEmployee'])->name('call_history');
Route::get('/call_history_detail', [CallHistoryController::class, 'callHistoryDetail'])->name('call_history_detail');
Route::get('/employee_call_history',[CallHistoryController::class, 'callHistoryByEmployee'])->name('employee_call_history');
Route::get('/leads_feedback',[LeadsController::class, 'filterLeadsByEmployee'])->name('leads_feedback');
Route::get('/leadsfeedback_detail', [LeadsController::class, 'leadsFeedbackDetail'])->name('leadsfeedback_detail');
Route::get('/call_history_today', [CallHistoryController::class, 'todayCallHistory'])->name('call_history_today');
Route::get('/today_call_history_detail', [CallHistoryController::class, 'todaycallhistoryDetail'])->name('today_call_history_detail');
Route::get('/filter_call_history', [CallHistoryController::class, 'filterCallHistory'])->name('filter_call_history');
Route::get('/outgoing_call_history', [CallHistoryController::class, 'outgoingCall'])->name('outgoing_call_history');
Route::get('/incoming_call_history', [CallHistoryController::class, 'incomingCall'])->name('incoming_call_history');
Route::get('/missed_call_history', [CallHistoryController::class, 'missedCall'])->name('missed_call_history');



Route::get('/upload', [LeadsController::class, 'showUploadForm'])->name('upload.form');
Route::post('/import', [LeadsController::class, 'import'])->name('leads.import');
Route::get('/filter_leads', [LeadsController::class, 'filterLeads'])->name('filter_leads');
Route::get('/today_leads', [LeadsController::class, 'todayLeads'])->name('today_leads');
Route::get('/dashboard', [CommonController::class, 'dashBoardCounts'])->name('dashboard');
Route::post('/add_leads', [LeadsController::class, 'createLeads'])->name('leads.store');
Route::post('/assign_leads_employee', [LeadsController::class, 'assignleadsToEmployee'])->name('assign_leads_employee');
Route::get('/leads_delete', [LeadsController::class, 'showdeleteLeads'])->name('leads_delete');
Route::get('/showleadsdelete_detail', [LeadsController::class, 'showdeleteleadsDetail'])->name('showleadsdelete_detail');
Route::get('/assign_leads', [EmployeeController::class, 'showCallerEmployee'])->name('assign_leads');
Route::post('/assign_leads', [LeadsController::class, 'assignLeads']);
Route::get('/get-cities/{state_id}', [LeadsController::class, 'getCities']);
// Route::post('/assign_leads', [LeadsController::class, 'storeID']);




Route::get('/edit_password/{id}', [EmployeeController::class, 'editPassword'])->name('edit_password');
Route::post('/update_password/{id}', [EmployeeController::class, 'updatePassword'])->name('update_password');
// Route::post('/employees/{id}/update', [EmployeeController::class, 'update'])->name('employees.update');


    Route::get('/add_employee', function () {
        return view('addEmployee');
    });
    // Route::get('/add_leads', function () {
    //     return view('addLeads');
    // });
    
    
    Route::get('/show_employee', [EmployeeController::class, 'showEmployees'])->name('show_employee');
    Route::get('/employee_detail', [EmployeeController::class, 'employeeDetail'])->name('employee_detail');
    
   
    Route::post('/add_employee', [EmployeeController::class, 'createEmployee'])->name('employees.store');
    Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::post('/employees/{id}/update', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    Route::get('/employees/{id}/toggle', [EmployeeController::class, 'toggleActive'])->name('employees.toggle');
    
    
    
    
    Route::get('/call_history',[CallHistoryController::class, 'filterCallHistoryByEmployee'])->name('call_history');
    
    Route::get('/call_history_detail', [CallHistoryController::class, 'callHistoryDetail'])->name('call_history_detail');
    
    
    
    Route::get('/employee_call_history',[CallHistoryController::class, 'callHistoryByEmployee'])->name('employee_call_history');
    
    Route::get('/leads_feedback',[LeadsController::class, 'filterLeadsByEmployee'])->name('leads_feedback');
    
    Route::get('/leadsfeedback_detail', [LeadsController::class, 'leadsFeedbackDetail'])->name('leadsfeedback_detail');
    
    
    
    
    Route::get('/upload', [LeadsController::class, 'showUploadForm'])->name('upload.form');
    Route::post('/import', [LeadsController::class, 'import'])->name('leads.import');
    
    Route::get('/call_history_today', [CallHistoryController::class, 'todayCallHistory'])->name('call_history_today');
    Route::get('/today_call_history_detail', [CallHistoryController::class, 'todaycallhistoryDetail'])->name('today_call_history_detail');
    
    
    Route::get('/filter_call_history', [CallHistoryController::class, 'filterCallHistory'])->name('filter_call_history');
    
    Route::get('/filter_leads', [LeadsController::class, 'filterLeads'])->name('filter_leads');
    Route::get('/today_leads', [LeadsController::class, 'todayLeads'])->name('today_leads');
    
    Route::get('/dashboard', [CommonController::class, 'dashBoardCounts'])->name('dashboard');
    
    Route::post('/add_leads_store', [LeadsController::class, 'createLeads'])->name('add_leads_store');
    Route::get('/add_leads', [LeadsController::class, 'showLeads'])->name('leads.store');

    Route::get('/leads_count{$stateId}', [LeadsController::class, 'getleadsCountByState'])->name('leads_count');



    Route::get('/today_sales', [SalesController::class, 'showTodaySales'])->name('today_sales');
    // Route::get('/sales', [SalesController::class, 'filterSales'])->name('sales');

    Route::get('/sales/{id}', [SalesController::class, 'showSaleDetails'])->name('sale_details');


    Route::get('/all_sale', [SalesController::class, 'allSales'])->name('all_sale');
    Route::get('/show_sale', [SalesController::class, 'highestSales'])->name('show_sale');
    Route::get('/show_call', [CallHistoryController::class, 'highestCalls'])->name('show_call');







});

require __DIR__.'/auth.php';