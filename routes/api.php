<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\CallHistoryController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




Route::post('/lead_feedback', [LeadController::class, 'lead_feedback']);



Route::post('/add_calls', [ApiController::class, 'add_calls'])->name('add_calls');
Route::post('/add_call_logs', [ApiController::class, 'add_call_logs'])->name('add_call_logs');

Route::post('/lead_calls', [ApiController::class, 'lead_calls'])->name('lead_calls');

Route::post('/login', [ApiController::class, 'login']);

Route::get('/lead_by_employee', [ApiController::class, 'lead_by_employee']);
Route::get('/close_lead_by_employee', [ApiController::class, 'close_lead_by_employee']);
Route::get('/new_lead_by_employee', [ApiController::class, 'new_lead_by_employee']);
Route::get('/lead_by_id', [ApiController::class, 'lead_by_id']);
Route::get('/lost_lead_by_employee', [ApiController::class, 'lost_lead_by_employee']);

Route::put('lead/{id}', [ApiController::class, 'update_lead']);
Route::put('lead_delete/{id}', [ApiController::class, 'delete_lead']);


// Route::get('/leads_Count', [ApiController::class, 'leads_Count']);


Route::get('/leads_count', [ApiController::class, 'leads_count']);
Route::get('/followup_leads', [ApiController::class, 'followup_leads']);




Route::get('/calls_count', [ApiController::class, 'calls_count']);

Route::get('/today_Call_History', [ApiController::class, 'today_Call_History']);






Route::get('/states', [ApiController::class, 'getStates']);

Route::get('/cities/{state_id}', [ApiController::class, 'getCities']);


Route::post('/add_sales', [ApiController::class, 'add_sales']);
Route::get('/show_sales_by_employee', [ApiController::class, 'show_sales_by_employee']);

 
Route::get('/today_top_sales', [ApiController::class, 'getTopSalesToday']);
Route::get('/month_top_sales', [ApiController::class, 'getTopSalesThisMonth']);

Route::get('/today_sales_by_employee', [ApiController::class, 'todaySalesByEmployee']);
Route::get('/month_sales_by_employee', [ApiController::class, 'monthSalesByEmployee']);


Route::get('/today_top_calls', [ApiController::class, 'TopCallsToday']);
Route::get('/month_top_calls', [ApiController::class, 'TopCallsThisMonth']);

Route::get('/get_message', [ApiController::class, 'getMessage']);

Route::post('/logout', [ApiController::class, 'logout']);



Route::post('/add_lead_review', [ApiController::class, 'add_lead_review']);

Route::get('/call_duration_by_employee', [ApiController::class, 'callDurationByEmployee']);








                                              






