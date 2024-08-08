<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Employee;
use App\Models\State;
use App\Models\City;
use Carbon\Carbon;


use Illuminate\Http\Request;

class SalesController extends Controller
{
    

public function showTodaySales()
{
    // Get the current date in Y-m-d format
    $today = Carbon::today()->toDateString();


    // Fetch sales records for the current date
    // $Sales = Sale::whereDate('created_at', $today)->get(); 
    $Sales = Sale::with(['state', 'city', 'employee'])->whereDate('created_at', $today)->get();


    // Return the view with the sales records
    // return view('todaySales', compact('Sales'));
    $employees = Employee::all();
    $state = State::all();
    $city = City::all();

    return view('todaySales', compact('Sales', 'employees', 'state', 'city' ));
}

    public function showSaleDetails(Request $request)
{
    $sale = Sale::findOrFail($request->id);
   
    return view('salesDetails')->with('sale', $sale);
}



public function allSales(Request $request)
    {
        // Retrieve filter inputs
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $employeeId = $request->input('employee_id');

        // Initialize the query builder
        $salesQuery = Sale::query(); // Correct initialization

        // Apply date range filters  
        if ($fromDate) {
            $salesQuery->whereDate('created_at', '>=', $fromDate);
        }

        if ($toDate) {
            $salesQuery->whereDate('created_at', '<=', $toDate);
        }

        // Apply employee filter
        if ($employeeId) {
            $salesQuery->where('employee_id', $employeeId);
        }

        // Execute the query
        $Sales = $salesQuery->get(); // Use $salesQuery

        // Get list of employees for the dropdown
        $employees = Employee::all();
        $states = State::all(); // If needed elsewhere

        // Return the view with the filtered sales data
        return view('allSales', compact('Sales', 'employees', 'states'));
    }
}

   



