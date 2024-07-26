<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Employee;
use Carbon\Carbon;


use Illuminate\Http\Request;

class SalesController extends Controller
{
    //


    public function showTodaySales()
    {
        // Retrieve all employees for the filter dropdown
        $employees = Employee::all();

        // Get today's date
        $today = Carbon::today();

        // Retrieve sales for today
        $sales = Sale::whereDate('created_at', $today)->get();

        return view('showSales', [
            'Sales' => $sales,
            'employees' => $employees
        ]);
    }
     

    // public function showSaleDetails($id)
    // {
    //     // Retrieve the sale details by ID with the employee relationship
    //     $sale = Sale::with('employee')->findOrFail($id);

    //     // Pass the sale details to the view
    //     return view('salesDetails', [
    //         'sale' => $sale
    //     ]);
    // }



    public function showSaleDetails(Request $request)
{
    $sale = Sale::findOrFail($request->id);
   
    return view('salesDetails')->with('sale', $sale);
}

}
