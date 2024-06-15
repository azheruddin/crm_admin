<?php

namespace App\Http\Controllers;

use App\Models\CallHistory;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon; // Import Carbon class


class CallHistoryController extends Controller
{
    //

    // show employees method 
    public function showCallHistory()
    {
        $CallHistory = CallHistory::orderBy('id', 'desc')->get();
        return view('allCalls')->with('CallHistory', $CallHistory);

        //    return blade
    }

    

    public function callHistoryByEmployee(Request $request)
{
    $CallHistoryByEmployee = CallHistory::where('employee_id', $request->employee_id)->orderBy('id', 'desc')->get();
    return view('callsByEmployee')->with('CallHistoryByEmployee', $CallHistoryByEmployee);
}



    public function callHistoryDetail(Request $request)
    {
        $calls = CallHistory::findOrFail($request->call_id);

        return view('callHistoryDetails')->with('calls', $calls);
    }


    public function todayCallHistory()
    {
        $today = Carbon::today();
        $callHistories = CallHistory::with('employee')->whereDate('created_at', $today)->orderBy('id', 'desc')->get();
        return view('todayCalls', compact('callHistories'));
    }



    public function todaycallhistoryDetail(Request $request)
    {
        $calls = CallHistory::findOrFail($request->call_id);

        return view('todayCallsDetails')->with('calls', $calls);
    }


    public function filterCallHistory(Request $request)
    {
        $query = CallHistory::with('employee');

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->input('to_date'));
        }

        $callHistories = $query->orderBy('id', 'desc')->get();

        return view('todayCalls', compact('callHistories'));
    }



// filter by employee
public function filterCallHistoryByEmployee(Request $request)

{
    // Validate incoming request data
    $validatedData = $request->validate([
        'from_date' => 'nullable|date',
        'to_date' => 'nullable|date',
        'employee_id' => 'nullable|integer',
    ]);

    // Start query with eager loading of employee
    $query = CallHistory::with('employee');

    // Filter by from_date if provided
    if ($request->filled('from_date')) {
        $query->whereDate('created_at', '>=', $validatedData['from_date']);
    }

    // Filter by to_date if provided
    if ($request->filled('to_date')) {
        $query->whereDate('created_at', '<=', $validatedData['to_date']);
    }

    // Filter by employee_id if provided
    if ($request->filled('employee_id')) {
        $query->where('employee_id', $validatedData['employee_id']);
    }

    // Retrieve filtered call histories ordered by id desc
    $callHistories = $query->orderBy('id', 'desc')->get();

    

    // Load active callers
    $employees = Employee::where('is_active', '1')->where('type', 'caller')->get();

    // Return view with filtered call histories and active employees
    return view('allCalls', compact('callHistories', 'employees'));
}


}