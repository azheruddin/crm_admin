<?php

namespace App\Http\Controllers;

use App\Models\CallHistory;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon; // Import Carbon class
use Illuminate\Support\Facades\DB;



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



    // Method to fetch today's call history
    public function outgoingCall()
    {
        // Fetch today's date
        $today = now()->format('Y-m-d');
        
        // Fetch call histories for today
        $callHistories = CallHistory::whereDate('created_at', $today)->where('type', 'outgoing')->get();
        
        
        return view('outgoing', compact('callHistories',));
    }

   

    public function incomingCall()
    {
        // Fetch today's date
        $today = now()->format('Y-m-d');
        
        // Fetch call histories for today
        $callHistories = CallHistory::whereDate('created_at', $today)->where('type', 'incoming')->get();
        
        
        return view('incoming', compact('callHistories',));
    }


    public function missedCall()
    {
        // Fetch today's date
        $today = now()->format('Y-m-d');
        
        // Fetch call histories for today
        $callHistories = CallHistory::whereDate('created_at', $today)->where('type', 'missed')->get();
        
        
        return view('missed', compact('callHistories',));
    }

    public function highestCalls()
    {
        // Get the start and end of today
        $startOfDay = Carbon::now()->startOfDay();
        $endOfDay = Carbon::now()->endOfDay();
    
        // Get the start and end of the current month
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
    
        // Query to get the top employees based on the number of calls made today
        $topCallsToday = DB::table('call_history AS calls')
            ->join('employees', 'calls.employee_id', '=', 'employees.id')
            ->select('employees.name as employee_name', DB::raw('COUNT(calls.id) as total_calls'))
            ->whereBetween('calls.created_at', [$startOfDay, $endOfDay])
            ->groupBy('employees.name')
            ->orderBy('total_calls', 'desc')
            ->get();
    
        // Query to get the top employees based on the number of calls made this month
        $topCallsMonth = DB::table('call_history AS calls')
            ->join('employees', 'calls.employee_id', '=', 'employees.id')
            ->select('employees.name as employee_name', DB::raw('COUNT(calls.id) as total_calls'))
            ->whereBetween('calls.created_at', [$startOfMonth, $endOfMonth])
            ->groupBy('employees.name')
            ->orderBy('total_calls', 'desc')
            ->get();
    
        // Return the view with the query results
        return view('highestCall', [
            'topCallsToday' => $topCallsToday,
            'topCallsMonth' => $topCallsMonth,
        ]);
    }
    
}