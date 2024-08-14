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


    // public function showSales()
    // {
    //     // Get today's date and the start of the month
    //     $today = Carbon::today();
    //     $startOfMonth = Carbon::now()->startOfMonth();
    //     $endOfMonth = Carbon::now()->endOfMonth();

    //     // Retrieve sales data for today
    //     // $todaySales = Sale::whereDate('created_at', $today)->get(['customer_name', 'amount']);

    //     $topSalesMonth = Sale::select('sales.employee_id', 'employees.name as employee_name', DB::raw('SUM(sales.amount) as total_sales'))
    //     ->join('employees', 'sales.employee_id', '=', 'employees.id')
    //     ->whereBetween('sales.created_at', [$startOfMonth, $endOfMonth])
    //     ->groupBy('sales.employee_id', 'employees.name')  // Group by employee ID and name
    //     ->orderBy('total_sales', 'desc')  // Order by the aggregated total sales
    //     ->get();


    //     $topSalesToday = Sale::select('sales.employee_id', 'employees.name as employee_name', DB::raw('SUM(sales.amount) as total_sales'))
    //     ->join('employees', 'sales.employee_id', '=', 'employees.id')
    //     ->whereDate('sales.created_at', $today)
    //     ->groupBy('sales.employee_id', 'employees.name')  // Group by employee ID and name
    //     ->orderBy('total_sales', 'desc')  // Order by the aggregated total sales
    //     ->get();
    //     // Retrieve sales data for the current month
    //     // $monthlySales = Sale::whereBetween('created_at', [$startOfMonth, $today])
    //     //     ->get(['customer_name', 'amount']);

    //     // Pass data to the view
    //     return view('highestSale', [
    //         'todaySales' => $topSalesToday,
    //         'monthlySales' => $topSalesMonth,
    //     ]);
    // }

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


