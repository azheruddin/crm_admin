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
Route::get('/lead_by_id', [ApiController::class, 'lead_by_id']);

Route::put('lead/{id}', [ApiController::class, 'update_lead']);


Route::get('/leads_Count', [ApiController::class, 'leads_Count']);


                                              






