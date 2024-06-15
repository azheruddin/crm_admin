<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CallHistoryController;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\CommonController;

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
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/add_employee', function () {
    return view('addEmployee');
});

// Route::get('/show_employee', function () {
//     return view('showEmployee');
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










