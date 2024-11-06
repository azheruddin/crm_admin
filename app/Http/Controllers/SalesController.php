<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Employee;
use App\Models\State;
use App\Models\City;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;



use Illuminate\Http\Request;

class SalesController extends Controller
{
    

    public function showTodaySales(Request $request)
{
    // Get the authenticated admin's ID
    $admin_id = auth()->id();

    // Debugging admin_id
    if (is_null($admin_id)) {
        return back()->withErrors('Admin ID is missing.');
    }

    // Get the current date in Y-m-d format
    $today = Carbon::today()->toDateString();

    // Get the selected employee ID from the request
    $employee_id = $request->input('employee_id');  

    // Fetch sales records for the current date, filtered by admin_id and optionally by employee_id
    $query = Sale::with(['state', 'city', 'employee'])
    ->whereDate('created_at', $today)
    ->whereHas('employee', function ($query) use ($admin_id, $employee_id) {
        // Ensure employee belongs to the authenticated admin
        $query->where('admin_id', $admin_id);

    // If an employee is selected, filter the sales by employee_id
    if ($employee_id) {
        $query->where('id', $employee_id); // assuming employee's id is the reference
    }
});

    // Execute the query and get the sales data
    $Sales = $query->get();

    // Debug the query
    // dd($query->toSql(), $query->getBindings());

    // Fetch all employees, states, and cities for the form dropdowns
    $employees = Employee::where('admin_id', $admin_id)->get();
    $state = State::all();
    $city = City::all();

    // Return the view with the sales records and other necessary data
    return view('todaySales', compact('Sales', 'employees', 'state', 'city'));
}

    

    public function showSaleDetails(Request $request)
{
    $sale = Sale::findOrFail($request->id);
   
    return view('salesDetails')->with('sale', $sale);
}



// public function allSales(Request $request)
//     {
//         // Retrieve filter inputs
//         $fromDate = $request->input('from_date');
//         $toDate = $request->input('to_date');
//         $employeeId = $request->input('employee_id');

//         // Initialize the query builder
//         $salesQuery = Sale::query(); // Correct initialization

//         // Apply date range filters  
//         if ($fromDate) {
//             $salesQuery->whereDate('created_at', '>=', $fromDate);
//         }

//         if ($toDate) {
//             $salesQuery->whereDate('created_at', '<=', $toDate);
//         }

//         // Apply employee filter
//         if ($employeeId) {
//             $salesQuery->where('employee_id', $employeeId);
//         }

//         // Execute the query
//         $Sales = $salesQuery->get(); // Use $salesQuery

//         // Get list of employees for the dropdown
//         $employees = Employee::all();
//         $states = State::all(); // If needed elsewhere

//         // Return the view with the filtered sales data
//         return view('allSales', compact('Sales', 'employees', 'states'));
//     }

public function allSales(Request $request)
{
    // Get the authenticated admin's ID
    $admin_id = auth()->id();

    // Retrieve filter inputs
    $fromDate = $request->input('from_date');
    $toDate = $request->input('to_date');
    $employeeId = $request->input('employee_id');

    // Initialize the query builder and filter by admin_id
    $salesQuery = Sale::where('admin_id', $admin_id); // Apply admin_id filter

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

    // Execute the query and get the sales data
    $Sales = $salesQuery->get();

    // Get list of employees for the dropdown
    $employees = Employee::where('admin_id', $admin_id)->get(); // Filter employees by admin_id
    $states = State::all(); // If needed elsewhere

    // Return the view with the filtered sales data and necessary dropdown data
    return view('allSales', compact('Sales', 'employees', 'states'));
}

    
    public function highestSales()
{
    $startOfMonth = Carbon::now()->startOfMonth();
    $endOfMonth = Carbon::now()->endOfMonth();
    $today = Carbon::today();

    $topSalesMonth = Sale::select('employees.name as employee_name', DB::raw('SUM(sales.amount) as total_sales'))
        ->join('employees', 'sales.employee_id', '=', 'employees.id')
        ->whereBetween('sales.created_at', [$startOfMonth, $endOfMonth])
        ->groupBy('employees.name')
        ->orderBy('total_sales', 'desc')
        ->get();

    $topSalesToday = Sale::select('employees.name as employee_name', DB::raw('SUM(sales.amount) as total_sales'))
        ->join('employees', 'sales.employee_id', '=', 'employees.id')
        ->whereDate('sales.created_at', $today)
        ->groupBy('employees.name')
        ->orderBy('total_sales', 'desc')
        ->get();

    return view('highestSale', ['topSales' => $topSalesMonth, 'topSalesToday' => $topSalesToday]);
}





   
}


