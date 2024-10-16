<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CallHistoryController;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NewLeadsUploadController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\MasterDataController;

use App\Http\Controllers\Auth\RegisteredUserController;

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

// Show the registration form
Route::get('/register', [RegisteredUserController::class, 'create'])
    ->name('register');

// Handle the registration request
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
Route::post('/register', [ManagerController::class, 'create'])->name('manager.store');


/////////////////manager
Route::get('/add_manager', function () {
    return view('addManager');
});
Route::get('/show_manager', [ManagerController::class, 'showManager'])->name('show_manager');
Route::post('/add_manager', [ManagerController::class, 'createManager'])->name('manager.store');
///////////////////////////////////////

Route::get('/show_employee', [EmployeeController::class, 'showEmployees'])->name('show_employee');
Route::get('/employee_detail', [EmployeeController::class, 'employeeDetail'])->name('employee_detail');
Route::post('/add_employee', [EmployeeController::class, 'createEmployee'])->name('employees.store');
Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
Route::post('/employees/{id}/update', [EmployeeController::class, 'update'])->name('employees.update');
Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
Route::get('/employees/{id}/toggle', [EmployeeController::class, 'toggleActive'])->name('employees.toggle');

Route::get('/employees/{id}/toggle_login', [EmployeeController::class, 'toggleActiveLogin'])->name('employees.toggle_login');
// Route::get('/employees/{id}/toggle', [EmployeeController::class, 'toggle'])->name('employees.toggle');




Route::get('/call_history',[CallHistoryController::class, 'filterCallHistoryByEmployee'])->name('call_history');
Route::get('/call_history_detail', [CallHistoryController::class, 'callHistoryDetail'])->name('call_history_detail');
Route::get('/employee_call_history',[CallHistoryController::class, 'callHistoryByEmployee'])->name('employee_call_history');
Route::get('/leads_feedback',[LeadsController::class, 'filterLeadsByEmployee'])->name('leads_feedback');
Route::get('/call_history_today', [CallHistoryController::class, 'todayCallHistory'])->name('call_history_today');
Route::get('/today_call_history_detail', [CallHistoryController::class, 'todaycallhistoryDetail'])->name('today_call_history_detail');
Route::get('/filter_call_history', [CallHistoryController::class, 'callHistory'])->name('filter_call_history');
Route::get('/outgoing_call_history', [CallHistoryController::class, 'outgoingCall'])->name('outgoing_call_history');
Route::get('/incoming_call_history', [CallHistoryController::class, 'incomingCall'])->name('incoming_call_history');
Route::get('/missed_call_history', [CallHistoryController::class, 'missedCall'])->name('missed_call_history');
Route::get('/unknown_call_history', [CallHistoryController::class, 'unknownCall'])->name('unknown_call_history');



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
    
    
    
    
    Route::get('/call_history',[CallHistoryController::class, 'filterCallHistory'])->name('call_history');
    
    Route::get('/call_history_detail', [CallHistoryController::class, 'callHistoryDetail'])->name('call_history_detail');
    
    Route::get('/call_history_today', [CallHistoryController::class, 'todayCallHistory'])->name('call_history_today');

    Route::get('/today_call_history_detail', [CallHistoryController::class, 'todaycallhistoryDetail'])->name('today_call_history_detail');
    
    
    
    // Route::get('/call_history_today', [EmployeeController::class, 'showCallerEmployee'])->name('call_history_today');   
    
    Route::get('/employee_call_history',[CallHistoryController::class, 'callHistoryByEmployee'])->name('employee_call_history');
    
    Route::get('/leads_feedback',[LeadsController::class, 'filterLeadsByEmployee'])->name('leads_feedback');
    Route::get('/new_leads',[LeadsController::class, 'new_leads_show'])->name('new_leads');
    Route::get('/leadsfeedback_detail', [LeadsController::class, 'leadsFeedbackDetail'])->name('leadsfeedback_detail');
    
    
    
    
    Route::get('/upload', [LeadsController::class, 'showUploadForm'])->name('upload.form');
    Route::post('/import', [LeadsController::class, 'import'])->name('leads.import');
    
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


    Route::post('/add_message', [ MessageController::class, 'addMessage'])->name('message.store');
   
    Route::get('/add_message', function () {
        return view('addMessage');
    });
    

    Route::get('/show_message', [MessageController::class, 'showMessage'])->name('show_message');

    Route::get('/message_detail/{id}', [MessageController::class, 'messageDetail'])->name('message_detail');
    
    Route::get('/message/{id}/edit', [MessageController::class, 'editMessage'])->name('message.edit');



    Route::post('/message/{id}/update', [MessageController::class, 'update'])->name('message.update');

 

    Route::delete('/messages/{id}', [MessageController::class, 'destroyMessage'])->name('messages.destroy');

    // Route::get('/dashboard', [CommonController::class, 'calls_count'])->name('dashboard');

    
    
   
    Route::post('/imports', [NewLeadsUploadController::class, 'create'])->name('importscreate');
    Route::get('/imports', [EmployeeController::class, 'showCallerEmployees'])->name('imports');


    Route::get('/call_duration', [CallHistoryController::class, 'callDuration'])->name('call_duration');

    Route::get('/call_duration_detail', [CallHistoryController::class, 'callDurationDetail'])->name('call_duration_detail');

    // Route::get('/leadsfeedback_detail', [LeadsController::class, 'leadsReview'])->name('leadsfeedback_detail');

    // Route::get('/leadsfeedback_detail/{id}', [LeadsController::class, 'leadsReview'])->name('leadsfeedback_detail');

    Route::get('/leadsfeedback_detail/{id}', [LeadsController::class, 'leadsFeedbackDetail'])->name('leadsfeedback_detail');


    Route::get('/count_leads', [LeadsController::class, 'countLeads'])->name('count_leads');
    Route::delete('/leads/{id}', [LeadsController::class, 'deleteLeads'])->name('leads.delete');

    
    Route::get('/interested_in', function () {
        return view('InterestedIn');  
    });
      

    // Route::get('/interested_in', [MasterDataController::class, 'interestedIn'])->name('interested_in');
    // Route::post('/interested_in', [MasterDataController::class, 'interested'])->name('interested_in');


    Route::match(['get', 'post'], '/interested_in', [MasterDataController::class, 'interestedIn'])->name('interested_in');





  
  
    

    // Route::get('/imports', function () {
    //     return view('NewLeadsUpload');
    // });




    


    















});

require __DIR__.'/auth.php';