<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Employee;
use Carbon\Carbon;


use Illuminate\Http\Request;

class SalesController extends Controller
{
    

public function showTodaySales()
{
    // Get the current date in Y-m-d format
    $today = Carbon::today()->toDateString();

    // Fetch sales records for the current date
    $Sales = Sale::whereDate('created_at', $today)->get();

    // Return the view with the sales records
    return view('todaySales', compact('Sales'));
}


      
    



    public function showSaleDetails(Request $request)
{
    $sale = Sale::findOrFail($request->id);
   
    return view('salesDetails')->with('sale', $sale);
}



public function allSales(Request $request) {
    // Retrieve filter inputs
    $fromDate = $request->input('from_date');
    $toDate = $request->input('to_date');
    $employeeId = $request->input('employee_id');

    // Query to get filtered sales records
    $salesQuery = Sale::query();

    if ($fromDate) {
        $salesQuery->where('date', '>=', $fromDate);
    }

    if ($toDate) {
        $salesQuery->where('date', '<=', $toDate);
    }

    if ($employeeId) {
        $salesQuery->where('employee_id', $employeeId);
    }

    $Sales = $salesQuery->get();

    // Get list of employees
    $employees = Employee::all();

    return view('allSales', compact('Sales', 'employees'));
}


   
}



