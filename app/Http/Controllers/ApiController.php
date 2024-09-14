<?php

namespace App\Http\Controllers;

use App\Models\CallHistory;
use App\Models\Leads;
use App\Models\Employee;
use App\Models\State;
use App\Models\City;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;  // read about this on google
// use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Message;

class ApiController extends Controller
{
    // 
    

    public function add_calls(Request $request)

    {
        
    
            $callHistory = new CallHistory();
            $callHistory->customer_name = $request->customer_name;
            $callHistory->contact_name = $request->contact_name;
            $callHistory->phone = $request->phone;
            $callHistory->call_type = $request->call_type;
            $callHistory->duration = $request->duration;           
            $callHistory->employee_id = $request->employee_id;           
            $callHistory->save();

        return response()->json([
            'message' => 'Data insert successfully',
            // 'data' => $callHistory
        ], 201);
    }
    
    

    public function lead_calls(Request $request)
    {
        
    
        $leads = new Leads();
            $leads->customer_name = $request->customer_name;
            $leads->customer_email = $request->customer_email;
            $leads->phone = $request->phone;
            $leads->employee_id = $request->employee_id;
            $leads->notes = $request->notes;
            $leads->lead_stage = $request->lead_stage;           
            $leads->feedback = $request->feedback;           
            $leads->expected_revenue = $request->expected_revenue;          
            $leads->next_follow_up = $request->next_follow_up;           
            //            
            $leads->save();
         

        return response()->json([
            'message' => 'Leads inserted successfully',
            'data' => $leads
        ], 201);
    }
    
    


    
// Employee login
public function login(Request $request)
{
 $validator = Validator::make($request->all(), [
    'phone' => 'required|digits:10', // Ensure phone is exactly 10 digits
    'password' => 'required|string',
]);

// Check if validation fails
if ($validator->fails()) {
    return response()->json([
        'message' => 'Validation error',
        'errors' => $validator->errors()
    ], 422);
}

// Fetch employee by phone number
$employee = Employee::where('phone', $request->phone)->first();

if (!$employee) {
    return response()->json([
        'status' => 'F',
        'message' => 'User not found',
    ], 404);
}

// Check if employee exists and if password matches
if ($request->password != $employee->password) {
    return response()->json([
        'status' => 'F',
        'message' => 'Invalid phone or password'
    ], 401);
}

// Check if employee is active
if ($employee->is_active == 0) {
    return response()->json([
        'status' => 'F',
        'message' => 'Account not active, please contact admin'
    ], 401);
}

// Return employee data on successful login
return response()->json([
    'status' => 'S',
    'message' => 'Login successful',
    'data' => $employee
]);
}
 

public function add_call_logs(Request $request)
{
    // Retrieve employee_id from the request
    $employeeId = $request->employee_id;

    // Array to store unique call logs
    $uniqueCallLogs = [];
    $requestCallLogs = $request->call_logs;

    foreach ($requestCallLogs as $data) {
        // Check if the call log already exists
        $existingCallLog = CallHistory::where('employee_id', $employeeId)
            ->where('call_date', $data['call_date'])
            ->exists();

        if (!$existingCallLog) {
            // Create a new call log
            $uniqueCallLogs[] = [
                'employee_id' => $employeeId,
                'phone' => $data['phone'],
                'type' => $data['type'],
                'call_date' => $data['call_date'],
                'call_duration' => $data['call_duration'],
                'contact_name' => $data['contact_name']
                // Add other fields as needed
            ];
        }
    }

    if (count($uniqueCallLogs) == 0) {
        // All records are duplicates
        return response()->json([
            'message' => 'All records are duplicates'
        ], 400);
    } else {
        // Bulk insert unique call logs
        CallHistory::insert($uniqueCallLogs);

        // Return message with count of unique records added
        return response()->json([
            'message' => count($uniqueCallLogs) . ' records added successfully'
        ], 201);
    }
}


    // show leads by employee
//     public function lead_by_employee(Request $request)
//     {
//         $leads = Leads::where('employee_id', $request->employee_id)->where('is_deleted', 0)->orderBy('id', 'desc')->get();
//         $data_record = array();
//         foreach ($leads as $row) {

//             $data_record[] = [
//                 'id' => $row->id,
//                 'customer_name' => $row->customer_name,
//                 'customer_email' => $row->customer_email,
//                 'phone' => $row->phone,
//                 'lead_stage' => $row->lead_stage,
//                 'feedback' => $row->feedback,
//                 'expected_revenue' => $row->expected_revenue,
//                 'notes' => $row->notes,
//                 'next_follow_up' => $row->next_follow_up,
//                 'employee_id' => $row->employee_id,
//             ];

//         }
//         $array = json_encode($data_record);
//         $array = json_decode($array);
//         if ($leads != null && $request->employee_id != null) {
//             return response()->json([
//                 'status' => 'S',
//                 'data' => $array,

//       ], 200, [], JSON_NUMERIC_CHECK);
//   } else {
//       return response()->json(['status' => 'F', 'errorMsg' => 'data Not found'], 200);
//   }
// }

public function lead_by_id(Request $request){
    $leads = Leads::where('id', $request->id)->where('is_deleted', 0)->first();
    $data_record = []; // Initialize data record array
    
    if($leads){
        $data_record = [
            'id' => $leads->id,
            'customer_name' => $leads->customer_name,
            'customer_email' => $leads->customer_email,
            'phone' => $leads->phone,
            'lead_stage' => $leads->lead_stage,
            'feedback' => $leads->feedback,
            'expected_revenue' => $leads->expected_revenue,
            'notes' => $leads->notes,
            'next_follow_up' => $leads->next_follow_up,
            'employee_id' => $leads->employee_id,
        ];
      
    }
   
    if ($leads != null && $request->id != null) {
        return response()->json([
            'status' => 'S',
            'data' => $data_record,
        ], 200, [], JSON_NUMERIC_CHECK);
    } else {
        return response()->json(['status' => 'F', 'errorMsg' => 'data Not found'], 200);
    }
}

public function update_lead(Request $request, $id)
{
    // Find the lead by ID
    $lead = Leads::find($id);

    // If lead does not exist, return error response
    if (!$lead) {
        return response()->json(['error' => 'Lead not found'], 404);
    }

    // Update lead properties with request data
    $lead->customer_name = $request->input('customer_name');
    $lead->customer_email = $request->input('customer_email');
    $lead->phone = $request->input('phone');
    $lead->employee_id = $request->input('employee_id');
    $lead->notes = $request->input('notes');
    $lead->lead_stage = $request->input('lead_stage');
    // $lead->feedback = $request->input('feedback');
    $lead->expected_revenue = $request->input('expected_revenue');
    $lead->next_follow_up = $request->input('next_follow_up');

    // Save the updated lead
    $lead->save();

    // Return success response
    return response()->json([
        'message' => 'Lead updated successfully',
        'data' => $lead
    ], 200);
}


public function delete_lead(Request $request, $id)
{
    // Find the lead by ID
    $lead = Leads::find($id);

    // If lead does not exist, return error response
    if (!$lead) {
        return response()->json(['error' => 'Lead not found'], 404);
    }

    $lead->delete_reason = $request->input('reason');
    $lead->employee_id = $request->input('employee_id');
    $lead->is_deleted = 1;

    // Save the updated lead
    $lead->save();

    // Return success response
    return response()->json([
        'message' => 'Lead Delete successfully'
    ], 200);
}


public function leads_count(Request $request)
{
    $employee_id = $request->input('employee_id');

    // leads
    $totalLeads = Leads::where('employee_id', $employee_id)
                       ->where('is_deleted', 0)
                       ->where('lead_stage','!=', 'new')
                       ->count();

    $newLeads = Leads::where('employee_id', $employee_id)
                     ->where('lead_stage', 'new')
                     ->where('is_deleted', 0)
                     ->count();

    $hotLeads = Leads::where('employee_id', $employee_id)
                     ->where('lead_stage', 'hot')
                     ->where('is_deleted', 0)
                     ->count();

    $interested = Leads::where('employee_id', $employee_id)
                       ->where('lead_stage', 'interested')
                       ->where('is_deleted', 0)
                       ->count();

    $notInterested = Leads::where('employee_id', $employee_id)
                          ->where('lead_stage', 'not_interested')
                          ->where('is_deleted', 0)
                          ->count();
    $notAnswered = Leads::where('employee_id', $employee_id)
                          ->where('lead_stage', 'not_answered')
                          ->where('is_deleted', 0)
                          ->count();

    // Return the counts as JSON response
    return response()->json([
        'totalLeads' => $totalLeads,
        'newLeads' => $newLeads,
        'hotLeads' => $hotLeads,
        'interested' => $interested,
        'notInterested' => $notInterested,
        'notAnswered' => $notAnswered,
        
    ]);
}


  public function lead_by_employee(Request $request)
{
    $query = Leads::where('employee_id', $request->employee_id)
                  ->where('is_deleted', 0);

    if ($request->has('lead_type')) {
        $query->where('lead_stage', $request->lead_type);
    }
    // if ($request->has('lead_type')) {
    //     $query->where('lead_stage', '!=', $request->lead_type);
    // }
    
   

    $leads = $query->orderBy('id', 'desc')->get();

    $data_record = [];

    foreach ($leads as $row) {
        $data_record[] = [
            'id' => $row->id,
            'customer_name' => $row->customer_name,
            'customer_email' => $row->customer_email,
            'phone' => $row->phone,
            'lead_stage' => $row->lead_stage,
            'feedback' => $row->feedback,
            'expected_revenue' => $row->expected_revenue,
            'notes' => $row->notes,
            'next_follow_up' => $row->next_follow_up,
            'employee_id' => $row->employee_id,
        ];
    }

    if (!empty($data_record)) {
        return response()->json([
            'status' => 'S',
            'data' => $data_record,
        ], 200, [], JSON_NUMERIC_CHECK);
    } else {
        return response()->json([
            'status' => 'F',
            'errorMsg' => 'Data not found',
        ], 200);
    }
}


 public function new_lead_by_employee(Request $request)
{
    $leads = Leads::where('employee_id', $request->employee_id)
                  ->where('is_deleted', 0)
                  ->where('lead_stage', 'new')
                  ->orderBy('id', 'desc')->get();

    

    $data_record = [];

    foreach ($leads as $row) {
        $data_record[] = [
            'id' => $row->id,
            'customer_name' => $row->customer_name,
            'customer_email' => $row->customer_email,
            'phone' => $row->phone,
            'lead_stage' => $row->lead_stage,
            'feedback' => $row->feedback,
            'expected_revenue' => $row->expected_revenue,
            'notes' => $row->notes,
            'next_follow_up' => $row->next_follow_up,
            'employee_id' => $row->employee_id,
        ];
    }

    if (!empty($data_record)) {
        return response()->json([
            'status' => 'S',
            'data' => $data_record,
        ], 200, [], JSON_NUMERIC_CHECK);
    } else {
        return response()->json([
            'status' => 'F',
            'errorMsg' => 'Data not found',
        ], 200);
    }
}

// public function followup_leads(Request $request)
// {
//     $query = Leads::where('employee_id', $request->employee_id)
//                   ->where('is_deleted', 0)
//                   ->whereNotNull('next_follow_up')
//                   ->where('next_follow_up', '>', now())
//                   ->orderBy('id', 'desc')
//                   ->get();

//     $data_record = [];

//     foreach ($query as $row) {
//         $data_record[] = [
//             'id' => $row->id,
//             'customer_name' => $row->customer_name,
//             'customer_email' => $row->customer_email,
//             'phone' => $row->phone,
//             'lead_stage' => $row->lead_stage,
//             'feedback' => $row->feedback,
//             'expected_revenue' => $row->expected_revenue,
//             'notes' => $row->notes,
//             'next_follow_up' => $row->next_follow_up,
//             'employee_id' => $row->employee_id,
//         ];
//     }

//     if (!empty($data_record)) {
//         return response()->json([
//             'status' => 'S',
//             'data' => $data_record,
//         ], 200, [], JSON_NUMERIC_CHECK);
//     } else {
//         return response()->json([
//             'status' => 'F',
//             'errorMsg' => 'Data not found',
//         ], 200);
//     }
// }


//////////////
public function followup_leads(Request $request)
{
    // $query = Leads::where('employee_id', $request->employee_id)
    //               ->where('is_deleted', 0)
    //               ->whereNotNull('next_follow_up')
    //             //   ->where('next_follow_up', '>=', now())
                
    //               ->orderBy('id', 'desc')
    //               ->get();
    
     $employeeId = $request->employee_id;

    // Perform the raw query with conversion
    $query = Leads::where('employee_id', $request->employee_id)
              ->where('is_deleted', 0)
              ->whereNotNull('next_follow_up')
              ->where('next_follow_up', '>=', now())
              ->orderBy('id', 'desc')
              ->get();

    // Log::info('Query executed:', ['query' => $query->toArray()]); // Log the result of the query

    $data_record = [];

    foreach ($query as $row) {
        $data_record[] = [
            'id' => $row->id,
            'customer_name' => $row->customer_name,
            'customer_email' => $row->customer_email,
            'phone' => $row->phone,
            'lead_stage' => $row->lead_stage,
            'feedback' => $row->feedback,
            'expected_revenue' => $row->expected_revenue,
            'notes' => $row->notes,
            'next_follow_up' => $row->next_follow_up,
            'employee_id' => $row->employee_id,
        ];
    }

    // Log::info('Data records:', ['data_record' => $data_record]); // Log the final data record

    if (!empty($data_record)) {
        return response()->json([
            'status' => 'S',
            'data' => $data_record,
        ], 200, [], JSON_NUMERIC_CHECK);
    } else {
        return response()->json([
            'status' => 'F',
            'errorMsg' => 'Data not found',
        ], 200);
    }
}
//////////////////////

//   public function calls_count(Request $request)
// {
//     $employee_id = $request->input('employee_id');
    
//   // Get today's date
//   $today = Carbon::today();

//   // Fetch the counts for different call types created today
//   $incomingCallsToday = CallHistory::where('type', 'Incoming')->where('employee_id', $employee_id)->whereDate('created_at', $today)->count();
//   $outgoingCallsToday = CallHistory::where('type', 'Outgoing')->where('employee_id', $employee_id)->whereDate('created_at', $today)->count();
//   $missedCallsToday = CallHistory::where('type', 'Missed')->where('employee_id', $employee_id)->whereDate('created_at', $today)->count();
//   $unknownCallsToday = CallHistory::where('type', 'unknown')->where('employee_id', $employee_id)->whereDate('created_at', $today)->count();
//   $todayCalls = CallHistory::whereDate('created_at', $today)->where('employee_id', $employee_id)->count();

   


//      return response()->json([
//             'total' => $todayCalls,
//             'outgoing' => $outgoingCallsToday,
//             'incoming' => $incomingCallsToday,
//             'missed' => $missedCallsToday,
//             'unknown' => $unknownCallsToday,
//         ]);
// }


// public function calls_count(Request $request)
// {
//     $employee_id = $request->input('employee_id');
    
//   // Get today's date
//   $today = Carbon::today();

  
  
//   $uniqueOutgoingCallsToday = CallHistory::where('type', 'Outgoing')
//   ->where('employee_id', $employee_id)
//   ->whereDate('created_at', $today)
//   ->select(DB::raw('COUNT(DISTINCT CONCAT(phone, "-", call_duration)) as unique_count'))
//   ->pluck('unique_count')
//   ->first();
//   $incoming = CallHistory::where('type', 'incoming')
//   ->where('employee_id', $employee_id)
//   ->whereDate('created_at', $today)
//   ->select(DB::raw('COUNT(DISTINCT CONCAT(phone, "-", call_duration)) as unique_count'))
//   ->pluck('unique_count')
//   ->first();

//  $missed = CallHistory::where('type', 'Missed')->where('employee_id', $employee_id)->whereDate('created_at', $today)->count();
//   $unknown = CallHistory::where('type', 'unknown')
//   ->where('employee_id', $employee_id)
//   ->whereDate('created_at', $today)
//   ->select(DB::raw('COUNT(DISTINCT CONCAT(phone, "-", call_duration)) as unique_count'))
//   ->pluck('unique_count')
//   ->first();

// $total = $uniqueOutgoingCallsToday + $incoming + $missed + $unknown;
   


//      return response()->json([
//             'total' => $total,
//             // 'outgoing' => $outgoingCallsToday,
//             'outgoing' => $uniqueOutgoingCallsToday,
//             'incoming' => $incoming,
//             'missed' => $missed,
//             'unknown' => $unknown,
//         ]);
        

// }

public function calls_count(Request $request)
{
    // Validate the employee_id
    $request->validate([
        'employee_id' => 'required|integer',
    ]);

    $employee_id = $request->employee_id;

    // Get today's date
    $today = Carbon::today();

    // Fetch the count of unique outgoing calls
    $uniqueOutgoingCallsToday = CallHistory::where('type', 'Outgoing')
        ->where('employee_id', $employee_id)
        ->whereDate('created_at', $today)
        ->select(DB::raw('COUNT(DISTINCT CONCAT(phone, "-", call_duration)) as unique_count'))
        ->pluck('unique_count')
        ->first();

    // Fetch the count of unique incoming calls 
    $uniqueIncomingCallsToday = CallHistory::where('type', 'incoming')
        ->where('employee_id', $employee_id)
        ->whereDate('created_at', $today)
        ->select(DB::raw('COUNT(DISTINCT CONCAT(phone, "-", call_duration)) as unique_count'))
        ->pluck('unique_count')
        ->first();

    // Fetch the count of missed calls
    $missedCallsToday = CallHistory::where('type', 'Missed')
        ->where('employee_id', $employee_id)
        ->whereDate('created_at', $today)
        ->count();

    // Fetch the count of unknown calls
    $uniqueUnknownCallsToday = CallHistory::where('type', 'unknown')
        ->where('employee_id', $employee_id)
        ->whereDate('created_at', $today)
        ->select(DB::raw('COUNT(DISTINCT CONCAT(phone, "-", call_duration)) as unique_count'))
        ->pluck('unique_count')
        ->first();

    // Calculate the total calls (sum of all types)
    $totalCallsToday = $uniqueOutgoingCallsToday + $uniqueIncomingCallsToday + $missedCallsToday + $uniqueUnknownCallsToday;

    // Return the response with all counts
    return response()->json([
        'total' => $totalCallsToday,
        'outgoing' => $uniqueOutgoingCallsToday,
        'incoming' => $uniqueIncomingCallsToday,
        'missed' => $missedCallsToday,
        'unknown' => $uniqueUnknownCallsToday,
    ], 200);
}





///////////////////////////////////////

public function today_Call_History(Request $request)
{
    $today = Carbon::today();
    $employee_id = $request->input('employee_id');
    
    $query = CallHistory::where('employee_id', $employee_id);

    // Filter by date range if provided 
    if ($request->has('from_date') && $request->has('to_date')) {
        $fromDate = Carbon::parse($request->input('from_date'))->startOfDay();
        $toDate = Carbon::parse($request->input('to_date'))->endOfDay();
        $query->whereBetween('created_at', [$fromDate, $toDate]);
    }

    // Fetch call histories for today
    $callHistories = $query->whereDate('created_at', $today)
                           ->orderByDesc('created_at')
                           ->get();

    // Format call duration to human-readable format
    $formattedCallHistories = $callHistories->map(function ($history) {
        $seconds = $history->call_duration;
        $minutes = floor($seconds / 60);
        $seconds %= 60;
        $formattedDuration = sprintf('%dmin %dsec', $minutes, $seconds);

        return [ 
            'id' => $history->id,
            'customer_name' => $history->customer_name,
            'contact_name' => $history->contact_name,
            'phone' => $history->phone,
            'type' => $history->type,
            'call_duration' => $formattedDuration,
            'created_at' => $history->created_at,
            'updated_at' => $history->updated_at,
            'employee_id' => $history->employee_id,
            'call_date' => $history->call_date,
        ];
    });

    if (!$formattedCallHistories->isEmpty()) {
        return response()->json([ 
            'status' => 'S',
            'data' => $formattedCallHistories,
        ], 200, [], JSON_NUMERIC_CHECK);
    } else {
        return response()->json([
            'status' => 'F',
            'errorMsg' => 'Data not found',
        ], 200);
    }
}

public function getCities($state_id)
    {
        $cities = City::where('state_id', $state_id)->get();
        return response()->json($cities);
    }

    public function getStates()
{
    $states = State::all();
    return response()->json($states);
}

    public function add_sales(Request $request)
    {


        $sale = new Sale();
        $sale->customer_name = $request->customer_name;
        $sale->business_name = $request->business_name;
        $sale->keys = $request->keys;
        $sale->free = $request->free;
        $sale->amount = $request->amount;
        $sale->transaction = $request->transaction;
        $sale->balance = $request->balance;
        $sale->state_id = $request->state;
        $sale->city_id = $request->city;
        $sale->employee_id = $request->employee_id;
        $sale->lead_id = $request->lead_id;
        //            
        $sale->save();


        return response()->json([
            'message' => 'Sales inserted successfully',
            'data' => $sale 
        ], 201);
    }
    
    ///////////
    
public function getTopSalesToday()
{
    $today = Carbon::today()->toDateString();  // Ensure the format matches your database

    $topSales = Sale::select('employees.name as employee_name', DB::raw('SUM(sales.amount) as total_sales'))
    ->join('employees', 'sales.employee_id', '=', 'employees.id')
    ->whereDate('sales.created_at', $today)
    ->groupBy('employees.name')  // Group by employee name
    ->orderBy('total_sales', 'desc')  // Order by the aggregated column
    ->get();

    return response()->json($topSales);
}

 public function getTopSalesThisMonth()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $topSales = Sale::select('employees.name as employee_name', DB::raw('SUM(sales.amount) as total_sales'))
        ->join('employees', 'sales.employee_id', '=', 'employees.id')
        ->whereBetween('sales.created_at', [$startOfMonth, $endOfMonth])
        ->groupBy('employees.name')  // Group by employee name
        ->orderBy('total_sales', 'desc')  // Order by the aggregated column
        ->get();
        return response()->json($topSales);
    }

// today sale by employee
public function todaySalesByEmployee(Request $request)
{
    // Retrieve employee_id from request parameter
    $employeeId = $request->employee_id;
    $today = Carbon::today()->toDateString();  // Ensure the format matches your database

    // Validate the employee_id (optional but recommended)
    if (!$employeeId) {
        return response()->json(['error' => 'Employee ID is required.'], 400);
    }

    // Fetch top sales for the specified employee
    $topSales = Sale::select('sales.employee_id', 'employees.name as employee_name', DB::raw('SUM(sales.amount) as total_sales'))
        ->join('employees', 'sales.employee_id', '=', 'employees.id')
        ->whereDate('sales.created_at', $today)
        ->where('sales.employee_id', $employeeId)  // Filter by employee_id
        ->groupBy('sales.employee_id', 'employees.name')  // Group by employee ID and name
        ->orderBy('total_sales', 'desc')  // Order by the aggregated total sales
        ->limit(5)
        ->get();

    return response()->json($topSales);
}


// month sale by employee
public function monthSalesByEmployee(Request $request)
{
    // Retrieve employee_id from request parameter
    $employeeId = $request->employee_id;
    $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

    // Validate the employee_id (optional but recommended)
    if (!$employeeId) {
        return response()->json(['error' => 'Employee ID is required.'], 400);
    }

    // Fetch top sales for the specified employee
    $topSales = Sale::select('sales.employee_id', 'employees.name as employee_name', DB::raw('SUM(sales.amount) as total_sales'))
        ->join('employees', 'sales.employee_id', '=', 'employees.id')
        ->whereBetween('sales.created_at', [$startOfMonth, $endOfMonth])
        ->where('sales.employee_id', $employeeId)  // Filter by employee_id
        ->groupBy('sales.employee_id', 'employees.name')  // Group by employee ID and name
        ->orderBy('total_sales', 'desc')  // Order by the aggregated total sales
        ->limit(5)
        ->get();

    return response()->json($topSales);
}



             

public function TopCallsToday()
{
    // Get the start and end of today
    $startOfDay = Carbon::now()->startOfDay();
    $endOfDay = Carbon::now()->endOfDay();

    $topEmployeesToday = DB::table('call_history AS calls')
        ->join('employees', 'calls.employee_id', '=', 'employees.id')
        ->select('employees.name as employee_name', DB::raw('COUNT(calls.id) as total_calls'))
        ->whereBetween('calls.created_at', [$startOfDay, $endOfDay])
        ->groupBy('employees.name')
        ->orderBy('total_calls', 'desc')
        ->get();

    // Return the result as a JSON response
    return response()->json($topEmployeesToday);
}


// public function TopCallsThisMonth()
// { 
//     $startOfMonth = Carbon::now()->startOfMonth(); 
//     $endOfMonth = Carbon::now()->endOfMonth();

//      $topEmployees = DB::table('call_history AS calls')
//     ->join('employees', 'calls.employee_id', '=', 'employees.id')
//     ->select('employees.name as employee_name', DB::raw('COUNT(calls.call_date) as total_calls'))   
//     ->whereBetween('calls.created_at', ['2024-08-01 00:00:00', '2024-08-31 23:59:59'])
//     ->groupBy('employees.name')
//     ->orderBy('total_calls', 'desc') 
//     ->get();

//     return response()->json($topEmployees);      
// } public function getMessage(Request $request)
// {
//     try {
//         // Check if 'id' is provided in the request
//         $id = $request->input('id');

//         if ($id) {
//             // Fetch a single message by ID
//             $message = Message::find($id);

//             if (!$message) {
//                 return response()->json([
//                     'status' => 'F',
//                     'message' => 'Message not found'
//                 ], 404); // 404 Not Found
//             }

//             return response()->json([
//                  'status' => 'S',
//                 'data' => $message
//             ], 200); // 200 OK
//         } else {
//             // Fetch all messages
//             $messages = Message::all();

//             return response()->json([
//                   'status' => 'S',
//                 'data' => $messages
//             ], 200); // 200 OK
//         }
//     } catch (\Exception $e) {
//         // Return general error
//         return response()->json([
//            'status' => 'F',
//             'message' => 'An error occurred',
//             'error' => $e->getMessage()
//         ], 500); // 500 Internal Server Error
//     }
// }

public function TopCallsThisMonth()
{
    // Get the start and end of the current month dynamically
    $startOfMonth = Carbon::now()->startOfMonth();
    $endOfMonth = Carbon::now()->endOfMonth();

    $topEmployees = DB::table('call_history AS calls')
        ->join('employees', 'calls.employee_id', '=', 'employees.id')
        ->select('employees.name as employee_name', DB::raw('COUNT(calls.id) as total_calls'))
        ->whereBetween('calls.created_at', [$startOfMonth, $endOfMonth])
        ->groupBy('employees.name')
        ->orderBy('total_calls', 'desc')
        ->get();

    // Return the result as a JSON response
    return response()->json($topEmployees);
}


public function show_sales_by_employee(Request $request)
{
    $sale = Sale::where('employee_id', $request->employee_id)
                  ->orderBy('id', 'desc')->get();

    

    $data_record = [];

    foreach ($sale as $row) {
        $data_record[] = [
            'id' => $row->id,
            'customer_name' => $row->customer_name,
            'business_name' => $row->business_name,
            'keys' => $row->keys,
            'free' => $row->free,
            'transaction' => $row->transaction,
            'balance' => $row->balance,
            'state' => $row->state,
            'city' => $row->city,
            'employee_id' => $row->employee_id,
            'lead_id' => $row->lead_id,
        ];
    }

    if (!empty($data_record)) {
        return response()->json([
            'status' => 'S',
            'data' => $data_record,
        ], 200, [], JSON_NUMERIC_CHECK);
    } else {
        return response()->json([
            'status' => 'F',
            'errorMsg' => 'Data not found',
        ], 200);
    }
}




public function callDurationByEmployee(Request $request)
{
    // // Validate the employee_id
    // $request->validate([
    //     'employee_id' => 'required|integer',
    // ]);

    $employee_id = $request->employee_id;
    
      $startOfDay = Carbon::now()->startOfDay();
    $endOfDay = Carbon::now()->endOfDay();

    // Fetch total incoming call duration
    $incomingDuration = CallHistory::where('employee_id', $employee_id)
        ->where('type', 'incoming')
         ->whereBetween('created_at', [$startOfDay, $endOfDay])
        ->sum('call_duration'); // Replace 'duration' with the correct column name

    // Fetch total outgoing call duration
    $outgoingDuration = CallHistory::where('employee_id', $employee_id)
        ->where('type', 'outgoing')
        ->whereBetween('created_at', [$startOfDay, $endOfDay])
        ->sum('call_duration'); // Replace 'duration' with the correct column name

         $totalDurationInSeconds = $incomingDuration + $outgoingDuration;

     // Convert durations to minutes and seconds format
     $incomingDurationFormatted = $this->formatDuration($incomingDuration);
     $outgoingDurationFormatted = $this->formatDuration($outgoingDuration);
     $totalDurationFormatted = $this->formatDuration($totalDurationInSeconds);

     return response()->json([
        'total_incoming_duration' => $incomingDurationFormatted, // Formatted in min:sec
        'total_outgoing_duration' => $outgoingDurationFormatted, // Formatted in min:sec
        'total_duration' => $totalDurationFormatted, // Formatted in min:sec
    ], 200);
}

private function formatDuration($seconds)
{
    $minutes = floor($seconds / 60);
    $remainingSeconds = $seconds % 60;

    // Return formatted as "min:sec" (e.g., "5:23")
    return sprintf('%02d:%02d', $minutes, $remainingSeconds);
}



}