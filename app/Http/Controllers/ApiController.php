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
use App\Models\LeadReviews;
use App\Models\InterestedIn;
use App\Models\SignatureMessage;
use App\Models\Business;



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
    
    // all leads
    $allLeads = Leads::where('employee_id', $employee_id)->count();
    // $allLeads = Leads::where('employee_id', $employee_id)
    //                   ->where('is_deleted', 0)->count();
    // follow up
    $totalLeads = Leads::where('employee_id', $employee_id)
                       ->where('is_deleted', 0)
                        ->whereNotIn('lead_stage', ['NEW', 'CLOSE', 'not_interested'])
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
    $close = Leads::where('employee_id', $employee_id)
                          ->where('lead_stage', 'close')
                          ->where('is_deleted', 0)
                          ->count();
     $deletedLeads = Leads::where('employee_id', $employee_id)
                       ->where('is_deleted', 1)->count();
                       
     $transferLeads = Leads::where('transfer_by', $employee_id)
                       ->where('is_deleted', 0)->count();

    // Return the counts as JSON response
    return response()->json([
        'allLeads' => $allLeads,
        'newLeads' => $newLeads,
        'followup' => $totalLeads,
        'hotLeads' => $hotLeads,
        'interested' => $interested,
        'notInterested' => $notInterested,
        'notAnswered' => $notAnswered,
        'close' => $close,
        'deletedLeads' => $deletedLeads,
        'transferLeads' => $transferLeads,
    ]);
}

/////// from ashhari


  public function lead_by_employee(Request $request)
{
    $query = Leads::where('employee_id', $request->employee_id)
                  ->where('is_deleted', 0)
                   ->whereNotIn('lead_stage', ['NEW', 'CLOSE', 'not_interested']);
                //   ->where('lead_stage', '!=', 'NEW');

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
             'city' => $row->city,
            'state' => $row->state,
              'lead_date' => Carbon::parse($row->created_at)->format('d-m-Y H:i:s'),
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

// for close lead only
public function close_lead_by_employee(Request $request)
{
    $query = Leads::where('employee_id', $request->employee_id)
                  ->where('is_deleted', 0)
                   ->where('lead_stage',  'close');

    
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
             'city' => $row->city,
            'state' => $row->state,
              'lead_date' => Carbon::parse($row->created_at)->format('d-m-Y H:i:s'),
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

// not intrested or LOST lead by employee
public function lost_lead_by_employee(Request $request)
{
    $query = Leads::where('employee_id', $request->employee_id)
                  ->where('is_deleted', 0)
                   ->where('lead_stage',  'not_interested');

    
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
             'city' => $row->city,
            'state' => $row->state,
              'lead_date' => Carbon::parse($row->created_at)->format('d-m-Y H:i:s'),
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
                  ->where('lead_stage', 'NEW')
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
            'city' => $row->city,
            'state' => $row->state,
              'lead_date' => Carbon::parse($row->created_at)->format('d-m-Y H:i:s'),
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
//////////////////
 
 


public function calls_count(Request $request)
{
    $employee_id = $request->input('employee_id');
    
  // Get today's date
  $today = Carbon::today();

  // Fetch the counts for different call types created today
 // $incomingCallsToday = CallHistory::where('type', 'Incoming')->where('employee_id', $employee_id)->whereDate('created_at', $today)->count();
//    $outgoingCallsToday = CallHistory::where('type', 'Outgoing')->where('employee_id', $employee_id)->whereDate('created_at', $today)->count();
//   $missedCallsToday = CallHistory::where('type', 'Missed')->where('employee_id', $employee_id)->whereDate('created_at', $today)->count();
//   $unknownCallsToday = CallHistory::where('type', 'unknown')->where('employee_id', $employee_id)->whereDate('created_at', $today)->count();
//   $todayCalls = CallHistory::whereDate('created_at', $today)->where('employee_id', $employee_id)->count();
  
  
  $uniqueOutgoingCallsToday = CallHistory::where('type', 'Outgoing')
  ->where('employee_id', $employee_id)
  ->whereDate('created_at', $today)
  ->select(DB::raw('COUNT(DISTINCT CONCAT(phone, "-", call_duration)) as unique_count'))
  ->pluck('unique_count')
  ->first();
  $incoming = CallHistory::where('type', 'incoming')
  ->where('employee_id', $employee_id)
  ->whereDate('created_at', $today)
  ->select(DB::raw('COUNT(DISTINCT CONCAT(phone, "-", call_duration)) as unique_count'))
  ->pluck('unique_count')
  ->first();
//   $missed = CallHistory::where('type', 'missed')
//   ->where('employee_id', $employee_id)
//   ->whereDate('created_at', $today)
//   ->select(DB::raw('COUNT(DISTINCT CONCAT(phone, "-", call_duration)) as unique_count'))
//   ->pluck('unique_count')
//   ->first();
 $missed = CallHistory::where('type', 'Missed')->where('employee_id', $employee_id)->whereDate('created_at', $today)->count();
  $unknown = CallHistory::where('type', 'unknown')
  ->where('employee_id', $employee_id)
  ->whereDate('created_at', $today)
  ->select(DB::raw('COUNT(DISTINCT CONCAT(phone, "-", call_duration)) as unique_count'))
  ->pluck('unique_count')
  ->first();
//   $total = CallHistory::where('employee_id', $employee_id)
//   ->whereDate('created_at', $today)
//   ->select(DB::raw('COUNT(DISTINCT CONCAT(phone, "-", call_duration)) as unique_count'))
//   ->pluck('unique_count')
//   ->first();

$total = $uniqueOutgoingCallsToday + $incoming + $missed + $unknown;
   


     return response()->json([
            'total' => $total,
            // 'outgoing' => $outgoingCallsToday,
            'outgoing' => $uniqueOutgoingCallsToday,
            'incoming' => $incoming,
            'missed' => $missed,
            'unknown' => $unknown,
        ]);
        

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
        //            
        $sale->save();


        return response()->json([
            'message' => 'Sales inserted successfully',
            'data' => $sale 
        ], 201);
    }
    
   
        
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


// public function TopCallsToday()
// {
//     // Get the start and end of today
//     $startOfDay = Carbon::now()->startOfDay();
//     $endOfDay = Carbon::now()->endOfDay();
   
//     $topEmployeesToday = DB::table('call_history AS calls')
//         ->join('employees', 'calls.employee_id', '=', 'employees.id')
//         ->select('employees.name as employee_name', DB::raw('COUNT(DISTINCT CONCAT(calls.phone, "-", calls.call_duration, "-", calls.created_at)) as total_calls'))
//         ->whereBetween('calls.created_at', [$startOfDay, $endOfDay])
//         ->groupBy('employees.name')
//         ->orderBy('total_calls', 'desc')
//         ->get();

//     // Return the result as a JSON response
//     return response()->json($topEmployeesToday);
// }

public function TopCallsToday($adminId)
{
    $startOfDay = Carbon::now()->startOfDay();
    $endOfDay = Carbon::now()->endOfDay();

    $topEmployeesToday = DB::table('call_history AS calls')
        ->join('employees', 'calls.employee_id', '=', 'employees.id')
        ->select('employees.id as employee_id', 'employees.name as employee_name', DB::raw('COUNT(DISTINCT CONCAT(calls.phone, "-", calls.call_duration, "-", calls.created_at)) as total_calls'))
        ->whereBetween('calls.created_at', [$startOfDay, $endOfDay])
        ->where('employees.admin_id', $adminId) // Filter by admin_id parameter
        ->groupBy('employees.id', 'employees.name')
        ->orderBy('total_calls', 'desc')
        ->get();

    return response()->json($topEmployeesToday);  
}

// public function TopCallsToday()
// {
//     // Get the start and end of today
//     $startOfDay = Carbon::now()->startOfDay();
//     $endOfDay = Carbon::now()->endOfDay();
   
//     $topEmployeesToday = DB::table('call_history AS calls')
//         ->join('employees', 'calls.employee_id', '=', 'employees.id')
//         ->select('employees.name as employee_name', DB::raw('COUNT(DISTINCT CONCAT(calls.phone, "-", calls.call_duration, "-", calls.created_at)) as total_calls'))
//         ->whereBetween('calls.created_at', [$startOfDay, $endOfDay])
//         ->where('employees.is_active', 1) // Add this condition for active employees
//         ->groupBy('employees.name')
//         ->orderBy('total_calls', 'desc')
//         ->get();

//     // Return the result as a JSON response
//     return response()->json($topEmployeesToday);
// }


public function TopCallsThisMonth()
{ 
    $startOfMonth = Carbon::now()->startOfMonth(); 
    $endOfMonth = Carbon::now()->endOfMonth();

     $topEmployees = DB::table('call_history AS calls')
    ->join('employees', 'calls.employee_id', '=', 'employees.id')
    ->select('employees.name as employee_name', DB::raw('COUNT(calls.call_date) as total_calls'))   
    ->whereBetween('calls.created_at', ['2024-08-01 00:00:00', '2024-08-31 23:59:59'])
    ->where('calls.type', '!=', NULL)
    ->groupBy('employees.name')
    ->orderBy('total_calls', 'desc') 
    ->get();

    return response()->json($topEmployees); 


}     


public function callDurationByEmployee(Request $request)
{
   

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

///////////review api
public function add_lead_review(Request $request)
{
   
      // Find the existing lead by lead_id
      $lead = Leads::find($request->lead_id);

      if (!$lead) {
          return response()->json(['message' => 'Lead not found'], 404);
      }
  
      // Update only the lead_stage
      $lead->lead_stage = $request->lead_stage;
      $lead->save(); // Save the changes
  
      // Now insert the feedback into the LeadReviews table
      $review = new LeadReviews();
      $review->lead_id = $lead->id;
      $review->employee_id = $request->employee_id; // The employee providing the feedback
      $review->review_text = $request->review_text;
      $review->call_date = now(); // Use current date and time
      $review->save(); // Save the review
  
      return response()->json([
          'message' => 'Lead review added successfully',
        //   'data' => [
        //       'lead' => $lead,
        //       'review' => $review
        //   ]
      ], 201);
}

public function review_by_lead(Request $request)
{
    $reviews = LeadReviews::where('lead_id', $request->lead_id)
                          ->orderBy('id', 'desc')
                          ->get();
    

    $data_record = [];

    foreach ($reviews as $row) {
        $data_record[] = [
            'id' => $row->id,
            
            'lead_id' => $row->lead_id,
            'review_text' => $row->review_text,
            'call_date' => Carbon::parse($row->dall_date)->format('d-m-Y H:i:s'),
            'employee_id' => $row->employee_id
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
/////////////////////

public function lead_transfer(Request $request, $id)
{
  $lead = Leads::where('id', $id)->where('employee_id', $request->employee_id)->where('lead_stage', 'NEW')->first();

    // If lead does not exist, return error response
    if (!$lead) {
        return response()->json(['error' => 'Lead not found'], 404);
    }

    $lead->transfer_reason = $request->input('transfer_reason');
    $lead->transfer_by = $request->employee_id;
    $lead->employee_id = $request->transfer_to;

    // Save the updated lead
    $lead->save();

    // Return success response
    return response()->json([
        'message' => 'Lead Transfer successfull'
    ], 200);
}

 public function caller_employees()
    {
        // Retrieve all employees, selecting only the id and name fields
        $employees = Employee::select('id', 'name')->where('type', 'caller')->get();

        // Return the employee list as a JSON response
        return response()->json($employees);
    }
//////////////////////////////

public function interestedIn(Request $request)
    {
        if ($request->isMethod('post')) {
            // Validate the input
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            // Create a new record in the 'interested_in' table
            $interestedIn = InterestedIn::create([
                'interested_type' => $request->name,
            ]);

            // Return a JSON response with success message and the created record
            return response()->json([
                'success' => true,
                'message' => 'Record added successfully!',
                'data' => $interestedIn
            ], 201); // 201 Created status code
        }

        // Fetch all records from the 'interested_in' table for GET request
        $interestedInRecords = InterestedIn::orderBy('interested_type', 'asc')->get();

        // Return the fetched data as a JSON response
        return response()->json([
            'success' => true,
            'data' => $interestedInRecords,
        ], 200); // 200 OK status code
    }





    // public function signatureMessage()
    // {
    //     // Fetch all records from the 'signature_message' table
    //     $signatureMessages = SignatureMessage::all();

    //     // Return the data as JSON
    //     return response()->json([
    //         'success' => true,
    //         'data' => $signatureMessages
    //     ]);
    // }


    public function signatureMessage(Request $request)
    {
        // Check if 'employee_id' is present in the query parameters
        $employee_id = $request->query('employee_id');

        if ($employee_id) {
            // Fetch records where employee_id matches the given parameter
            $signatureMessages = SignatureMessage::where('employee_id', $employee_id)->get();

            // Check if any records were found
            if ($signatureMessages->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No signature messages found.'
                ], 404);
            }

            // Return the filtered data as JSON
            return response()->json([
                'success' => true,
                'data' => $signatureMessages
            ]);
        }

        // If no employee_id is provided, fetch all records 
        $signatureMessages = SignatureMessage::all();

        // Return all records as JSON
        return response()->json([
            'success' => true,
            'data' => $signatureMessages
        ]);
    }


   
    

    public function fetchLeadsFromToday(Request $request)
    {
        // Validate the employee_id input to ensure it exists in the employees table
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
        ]);
    
        // Get the employee ID from the request
        $employeeId = $request->input('employee_id');
    
        // Get the current timestamp to compare with next_follow_up
        $now = Carbon::now();
    
        // Fetch leads using the custom scope
        $leads = Leads::findByEmployeeId($employeeId)  // Custom scope
            ->whereRaw("STR_TO_DATE(next_follow_up, '%Y-%m-%d %H:%i:%s') >= ?", [$now])
            ->whereIn('lead_stage', ['hot', 'interested']) 
            ->orderByRaw("STR_TO_DATE(next_follow_up, '%Y-%m-%d %H:%i:%s') ASC")  // Order by next_follow_up (ascending)
            ->get();

              $leads->transform(function ($lead) {
        $lead->next_follow_up = Carbon::createFromFormat('Y-m-d H:i:s', $lead->next_follow_up)
                                      ->format('Y-m-d h:i:s A');  // Convert to 12-hour format
        return $lead;
    });
    
        // If no leads are found, return an empty array
        if ($leads->isEmpty()) {
            return response()->json([
                'leads' => [],
            ], 200);
        }
    
        // Otherwise, return the fetched leads
        return response()->json([
            'leads' => $leads,
        ], 200);
    }



     

 
    public function businessIn(Request $request)
    {
        if ($request->isMethod('post')) {
            // Validate the input
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            // Create a new record in the 'interested_in' table
            $businessIn = Business::create([
                'business_type' => $request->name,
            ]);

            // Return a JSON response with success message and the created record
            return response()->json([
                'success' => true,
                'message' => 'Record added successfully!',
                'data' => $businessIn
            ], 201); // 201 Created status code
        }

        // Fetch all records from the 'interested_in' table for GET request
        $businessInRecords = Business::orderBy('business_type', 'asc')->get();

        // Return the fetched data as a JSON response
        return response()->json([
            'success' => true,
            'data' => $businessInRecords,
        ], 200); // 200 OK status code
    }
      
}




