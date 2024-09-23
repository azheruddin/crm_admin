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
    

    




// public function callDuration(Request $request)
// {
//     // $employee_id = $request->employee_id;

//     // Fetch the employee record
//     // $employee = Employee::find($employee_id);  // Assuming Employee is your model

   

//     // Define start and end of the day
//     $startOfDay = Carbon::now()->startOfDay();
//     $endOfDay = Carbon::now()->endOfDay();

//     // Fetch total incoming call duration
//     $incomingDuration = CallHistory::where('employee_id', $employee_id)
//         ->where('type', 'incoming')
//         ->whereBetween('created_at', [$startOfDay, $endOfDay])
//         ->sum('call_duration');

//     // Fetch total outgoing call duration
//     $outgoingDuration = CallHistory::where('employee_id', $employee_id)
//         ->where('type', 'outgoing')
//         ->whereBetween('created_at', [$startOfDay, $endOfDay])
//         ->sum('call_duration');

//     $totalDurationInSeconds = $incomingDuration + $outgoingDuration;

//     // Convert durations to minutes and seconds format
//     $incomingDurationFormatted = $this->formatDuration($incomingDuration);
//     $outgoingDurationFormatted = $this->formatDuration($outgoingDuration);
//     $totalDurationFormatted = $this->formatDuration($totalDurationInSeconds);

//     // Pass data to the view, including the employee
//     return view('callDurationSum', [
//         'employee' => $employee,  // Passing employee data
//         'incomingDurationFormatted' => $incomingDurationFormatted,
//         'outgoingDurationFormatted' => $outgoingDurationFormatted,
//         'totalDurationFormatted' => $totalDurationFormatted,
//     ]);
// }


// private function formatDuration($seconds)
// {
//     $minutes = floor($seconds / 60);
//     $remainingSeconds = $seconds % 60;

//     // Return formatted as "min:sec" (e.g., "5:23")
//     return sprintf('%02d:%02d', $minutes, $remainingSeconds);
// }


// public function callDuration(Request $request)
// {
//     $employee_id = $request->employee_id;

//     // Fetch the employee record
//     $employee = Employee::find($employee_id);

//     if (!$employee) {
//         return redirect()->back()->with('error', 'Employee not found.');
//     }

//     // Define start and end of the day
//     $startOfDay = Carbon::now()->startOfDay();
//     $endOfDay = Carbon::now()->endOfDay();

//     // Fetch total call durations (incoming and outgoing) in one query
//     $callDurations = CallHistory::where('employee_id', $employee_id)
//         ->whereBetween('created_at', [$startOfDay, $endOfDay])
//         ->selectRaw("SUM(CASE WHEN type = 'incoming' THEN call_duration ELSE 0 END) as incomingDuration,
//                      SUM(CASE WHEN type = 'outgoing' THEN call_duration ELSE 0 END) as outgoingDuration")
//         ->first();

//     // Calculate total duration
//     $totalDurationInSeconds = $callDurations->incomingDuration + $callDurations->outgoingDuration;

//     // Format durations for display
//     $incomingDurationFormatted = $this->formatDuration($callDurations->incomingDuration);
//     $outgoingDurationFormatted = $this->formatDuration($callDurations->outgoingDuration);
//     $totalDurationFormatted = $this->formatDuration($totalDurationInSeconds);

//     // Pass data to the view
//     return view('callDurationSum', [
//         'employee' => $employee,
//         'incomingDurationFormatted' => $incomingDurationFormatted,
//         'outgoingDurationFormatted' => $outgoingDurationFormatted,
//         'totalDurationFormatted' => $totalDurationFormatted,
//     ]);
// }

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


    public function callDuration(Request $request)
{
    // Fetch all employees (or you can filter specific employees as needed)
    $employees = Employee::all();

    // Define start and end of the day
    $startOfDay = Carbon::now()->startOfDay();
    $endOfDay = Carbon::now()->endOfDay();

    // Prepare an array to store employee data with call durations
    $employeeDurations = [];

    // Loop through each employee and calculate call durations
    foreach ($employees as $employee) {
        // Fetch total incoming call duration for the employee
        $incomingDuration = CallHistory::where('employee_id', $employee->id)
            ->where('type', 'incoming')
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->sum('call_duration');

        // Fetch total outgoing call duration for the employee
        $outgoingDuration = CallHistory::where('employee_id', $employee->id)
            ->where('type', 'outgoing')
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->sum('call_duration');

        // Calculate the total duration
        $totalDurationInSeconds = $incomingDuration + $outgoingDuration;

        // Convert durations to minutes and seconds format
        $incomingDurationFormatted = $this->formatDuration($incomingDuration);
        $outgoingDurationFormatted = $this->formatDuration($outgoingDuration);
        $totalDurationFormatted = $this->formatDuration($totalDurationInSeconds);

        // Add the employee's data to the array
        $employeeDurations[] = [
            'employee' => $employee,
            'incomingDurationFormatted' => $incomingDurationFormatted,
            'outgoingDurationFormatted' => $outgoingDurationFormatted,
            'totalDurationFormatted' => $totalDurationFormatted,
        ];
    }

}

}

       
    

