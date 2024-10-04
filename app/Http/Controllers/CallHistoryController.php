<?php

namespace App\Http\Controllers;

use App\Models\CallHistory;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon; // Import Carbon class
use Illuminate\Support\Facades\DB;



class CallHistoryController extends Controller
{
    
 
    public function showCallHistory()
    {
        $CallHistory = CallHistory::orderBy('id', 'desc')->get();
        return view('allCalls')->with('CallHistory', $CallHistory);

    }
   
    
     

//     public function callHistoryByEmployee(Request $request) 
// {
//     $CallHistoryByEmployee = CallHistory::where('employee_id', $request->employee_id)->orderBy('id', 'desc')->get();
//     return view('callsByEmployee')->with('CallHistoryByEmployee', $CallHistoryByEmployee);
// }

                 
    
    public function callHistoryDetail(Request $request)
    {
        $calls = CallHistory::findOrFail($request->call_id);

        return view('callHistoryDetails')->with('calls', $calls); 
    }


    
    public function todayCallHistory(Request $request)
    {


        $employee_id = $request->employee_id;

        $today = Carbon::today();
        $callHistoriesQuery = CallHistory::with('employee')
            ->whereDate('created_at', $today)
            
            ->selectRaw('MAX(id) as id, CONCAT(phone, "-", call_duration) as phone_duration, phone, call_duration, employee_id, type, contact_name ,  MAX(call_date) as call_date   ') // Select specific columns
            ->groupBy('phone', 'call_duration', 'employee_id','type', 'contact_name') // Group by necessary columns
            ->orderBy('call_date', 'desc');
            // ->get();

            if ($employee_id) {
                $callHistoriesQuery->where('employee_id', $employee_id);
            }

            $callHistories = $callHistoriesQuery->get();

            $employees = Employee::where('is_active', '1')->where('type', 'caller')->get();
    
        return view('todayCalls', compact('callHistories', 'employees'));
    }


//     public function callHistory(Request $request)
// {
//     // Fetch all employees
//     $employees = Employee::all(); // This ensures you have the $employees variable

//     // Get the employee ID from the request (if any)
//     $employee_id = $request->employee_id;

//     // Set the start and end of the day to filter the calls
//     $startOfDay = Carbon::now()->startOfDay();
//     $endOfDay = Carbon::now()->endOfDay();

//     // Initialize the query for CallHistory
//     $query = CallHistory::query();

//     // If an employee is selected, add a condition to filter by employee ID
//     if ($employee_id) {
//         $query->where('employee_id', $employee_id);
//     }

//     // Filter by today's date range
//     $query->whereBetween('created_at', [$startOfDay, $endOfDay]);

//     // Fetch the filtered call histories
//     $callHistories = $query->get();

//     // Pass $employees and $callHistories to the view
//     return view('todayCalls', [
//         'employees' => $employees,   // Passing $employees to the view
//         'callHistories' => $callHistories
//     ]);
// }




    public function todaycallhistoryDetail(Request $request)
    {
        $calls = CallHistory::findOrFail($request->call_id);

        return view('todayCallsDetails')->with('calls', $calls);
    }


   


public function filterCallHistory(Request $request)
{
    // Fetch all employees
    $employees = Employee::all();

    // Fetch employee ID from the request
    $employee_id = $request->employee_id;

    // Fetch from_date and to_date from the request
    $from_date = $request->from_date;
    $to_date = $request->to_date;

    // If employee_id or date range is missing, return empty data
    if (!$employee_id || !$from_date || !$to_date) {
        return view('allCalls', [
            'employees' => $employees,
            'callHistories' => collect() // Return an empty collection
        ]);
    }

    // Convert dates to Carbon instances
    $startOfDay = Carbon::parse($from_date)->startOfDay();
    $endOfDay = Carbon::parse($to_date)->endOfDay();

    // Build the query for CallHistory
    $query = CallHistory::query()
        ->where('employee_id', $employee_id)
        ->whereBetween('call_date', [$startOfDay, $endOfDay]);

    $callHistories = $query
        ->selectRaw('MAX(id) as id, CONCAT(phone, "-", call_duration) as phone_duration, phone, call_duration, employee_id, type, contact_name, MAX(call_date) as call_date')
        ->groupBy('phone', 'call_duration', 'employee_id', 'type', 'contact_name')
        ->orderBy('call_date', 'desc')
        ->get();

    // Pass $employees and $callHistories to the view
    return view('allCalls', [
        'employees' => $employees,
        'callHistories' => $callHistories
    ]);
}








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


    public function unknownCall()
    {
        // Fetch today's date
        $today = now()->format('Y-m-d');
        
        // Fetch call histories for today
        $callHistories = CallHistory::whereDate('created_at', $today)->where('type', 'unknown')->get();
        
        
        return view('unknown', compact('callHistories',));
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
    
        // Query to get the top employees based on the number of unique calls made today
        $topCallsToday = DB::table('call_history AS calls')
            ->join('employees', 'calls.employee_id', '=', 'employees.id')
            ->select('employees.name as employee_name', DB::raw('COUNT(DISTINCT CONCAT(calls.phone, calls.call_duration)) as total_calls'))
            ->whereBetween('calls.created_at', [$startOfDay, $endOfDay])
            ->groupBy('employees.name')
            ->orderBy('total_calls', 'desc')
            ->get();
    
        // Query to get the top employees based on the number of unique calls made this month
        $topCallsMonth = DB::table('call_history AS calls')
            ->join('employees', 'calls.employee_id', '=', 'employees.id')
            ->select('employees.name as employee_name', DB::raw('COUNT(DISTINCT CONCAT(calls.phone, calls.call_duration)) as total_calls'))
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

private function formatDuration($seconds)
{
    $minutes = floor($seconds / 60);
    $remainingSeconds = $seconds % 60;

    // Return formatted as "min:sec"
    return sprintf('%02d:%02d', $minutes, $remainingSeconds);
}


   
    public function callDurationDetail($call_id)
    {
        // Find the call duration record by its ID and load the related employee
        $duration = CallDuration::with('employee')->findOrFail($call_id);

        // Convert incoming duration (seconds) to minutes and seconds
        $incomingMinutes = floor($duration->incoming_duration / 60);
        $incomingSeconds = $duration->incoming_duration % 60;

        // Convert outgoing duration (seconds) to minutes and seconds
        $outgoingMinutes = floor($duration->outgoing_duration / 60);
        $outgoingSeconds = $duration->outgoing_duration % 60;

        // Calculate total duration (incoming + outgoing)
        $totalDuration = $duration->incoming_duration + $duration->outgoing_duration;
        $totalMinutes = floor($totalDuration / 60);
        $totalSeconds = $totalDuration % 60;

        // Pass the calculated values and duration data to the view
        return view('call_duration_detail', [
            'duration' => $duration,
            'incomingMinutes' => $incomingMinutes,
            'incomingSeconds' => $incomingSeconds,
            'outgoingMinutes' => $outgoingMinutes,
            'outgoingSeconds' => $outgoingSeconds,
            'totalMinutes' => $totalMinutes,
            'totalSeconds' => $totalSeconds,
        ]);
    }


    // public function callDuration(Request $request)
    // {
    //     // Get the employee_id from the request (if any)
    //     $employeeId = $request->get('employee_id');
    
    //     // Build the query to get employees with lead and call counts
    //     $employees = Employee::withCount([
    //         'leads as all',
    //         'leads as newLeads' => function ($query) {
    //             $query->where('lead_stage', 'NEW');
    //         },
    //         'calls as todayCalls' => function ($query) {
    //             $query->whereDate('created_at', Carbon::today());
    //         },
    //         'calls as incomingCalls' => function ($query) {
    //             $query->where('type', 'INCOMING'); // Use 'type' instead of 'call_type'
    //         },
    //         'calls as outgoingCalls' => function ($query) {
    //             $query->where('type', 'OUTGOING');
    //         },
    //         'calls as missedCalls' => function ($query) {
    //             $query->where('type', 'MISSED');
    //         },
    //         'calls as unknownCalls' => function ($query) {
    //             $query->where('type', 'UNKNOWN');
    //         }
    //     ]);
    
    //     // Apply the filter by employee if an employee is selected
    //     if (!empty($employeeId)) {
    //         $employees->where('id', $employeeId);
    //     }
    
    //     // Get the result of the query
    //     $employees = $employees->get();
    
    //     // Return the view with the employees data
    //     return view('callDurationSum', compact('employees'));
    // }



//     public function callDuration(Request $request)
// {
//     // Get the employee_id from the request (if any)
//     $employeeId = $request->get('employee_id');

//     // Build the query to get employees with lead and call counts
//     $employees = Employee::withCount([
//         // Count all leads
//         'leads as all',

//         // Count today's calls
//         'calls as todayCalls' => function ($query) {
//             $query->whereDate('created_at', Carbon::today()); // Filter by today's date
//         },

//         // Count today's incoming calls
//         'calls as incomingCalls' => function ($query) {
//             $query->where('type', 'INCOMING')
//                   ->whereDate('created_at', Carbon::today()); // Filter by today's date
//         },

//         // Count today's outgoing calls
//         'calls as outgoingCalls' => function ($query) {
//             $query->where('type', 'OUTGOING')
//                   ->whereDate('created_at', Carbon::today()); // Filter by today's date
//         },

//         // Count today's missed calls
//         'calls as missedCalls' => function ($query) {
//             $query->where('type', 'MISSED')
//                   ->whereDate('created_at', Carbon::today()); // Filter by today's date
//         },

//         // Count today's unknown calls
//         'calls as unknownCalls' => function ($query) {
//             $query->where('type', 'UNKNOWN')
//                   ->whereDate('created_at', Carbon::today()); // Filter by today's date
//         }
//     ]);

//     // Apply the filter by employee if an employee is selected
//     if (!empty($employeeId)) {
//         $employees->where('id', $employeeId);
//     }

//     // Get the result of the query
//     $employees = $employees->get();



//     // Return the view with the employees data
//     return view('callDurationSum', compact('employees'));
// }
   


// public function callDuration(Request $request)
// {
//     // Get the employee_id from the request (if any)
//     $employeeId = $request->get('employee_id');

//     // Build the query to get employees with call counts
//     $employees = Employee::withCount([
//         // Count today's calls
//         'calls as todayCalls' => function ($query) {
//             $query->whereDate('created_at', Carbon::today());
//         },

//         // Count today's incoming calls
//         'calls as incoming' => function ($query) {
//             $query->where('type', 'INCOMING')
//                   ->whereDate('created_at', Carbon::today());
//         },

//         // Count today's outgoing calls
//         'calls as outgoing' => function ($query) {
//             $query->where('type', 'OUTGOING')
//                   ->whereDate('created_at', Carbon::today());
//         },

//         // Count today's missed calls
//         'calls as missed' => function ($query) {
//             $query->where('type', 'MISSED')
//                   ->whereDate('created_at', Carbon::today());
//         },

//         // Count today's unknown calls
//         'calls as unknown' => function ($query) {
//             $query->where('type', 'UNKNOWN')
//                   ->whereDate('created_at', Carbon::today());
//         }
//     ]);

//     // Apply the filter by employee if an employee is selected
//     if (!empty($employeeId)) {
//         $employees->where('id', $employeeId);
//     }

//     // Get the result of the query
//     $employees = $employees->get();

//     $employeesSelect = Employee::where('is_active', '1')->where('type', 'caller')->get();

//     // Return the view with the employees data
//     return view('callDurationSum', compact('employees', 'employeesSelect'));
// }


public function callDuration(Request $request)
{
    // Get the employee_id from the request (if any)
    $employeeId = $request->get('employee_id');

    // Build the query to get employees with call counts for today
    $employees = Employee::withCount([
        // Count today's total calls
        'calls as todayCalls' => function ($query) {
            $query->whereDate('created_at', Carbon::today());
        },

        // Count today's incoming calls
        'calls as incoming' => function ($query) {
            $query->where('type', 'INCOMING')
                  ->whereDate('created_at', Carbon::today());
        },

        // Count today's outgoing calls
        'calls as outgoing' => function ($query) {
            $query->where('type', 'OUTGOING')
                  ->whereDate('created_at', Carbon::today());
        },

        // Count today's missed calls
        'calls as missed' => function ($query) {
            $query->where('type', 'MISSED')
                  ->whereDate('created_at', Carbon::today());
        },

        // Count today's unknown calls
        'calls as unknown' => function ($query) {
            $query->where('type', 'UNKNOWN')
                  ->whereDate('created_at', Carbon::today());
        }
    ]);

    // Apply filter by employee if an employee is selected
    if (!empty($employeeId)) {
        $employees->where('id', $employeeId);
    }

    // Fetch the results
    $employees = $employees->get();

    // Fetch active callers for the dropdown
    $employeesSelect = Employee::where('is_active', '1')->where('type', 'caller')->get();

    // Return the view with the employees data
    return view('callDurationSum', compact('employees', 'employeesSelect'));
}


}    


