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

use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;


class ApiController extends Controller
{
    //


    public function add_calls(Request $request)
    {


        $callHistory = new CallHistory();
        $callHistory->customer_name = $request->customer_name;
        $callHistory->phone = $request->phone;
        $callHistory->call_type = $request->call_type;
        $callHistory->duration = $request->duration;
        $callHistory->employee_id = $request->employee_id;
        $callHistory->save();

        return response()->json([
            'message' => 'Data insert successfully',
            'data' => $callHistory
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
                    'call_duration' => $data['call_duration']
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
    $lead->feedback = $request->input('feedback');
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

    // Return the counts as JSON response
    return response()->json([
        'totalLeads' => $totalLeads,
        'newLeads' => $newLeads,
        'hotLeads' => $hotLeads,
        'interested' => $interested,
        'notInterested' => $notInterested,
    ]);
}


public function lead_by_employee(Request $request)
{
    $query = Leads::where('employee_id', $request->employee_id)
                  ->where('is_deleted', 0);

    if ($request->has('lead_type')) {
        $query->where('lead_stage', $request->lead_type);
    }

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

public function followup_leads(Request $request)
{
    $employee_id = $request->input('employee_id');
    
   // Get today's date
   $today = Carbon::today();

   // Fetch the counts for different call types created today
   $incomingCallsToday = CallHistory::where('type', 'Incoming')->where('employee_id', $employee_id)->whereDate('created_at', $today)->count();
   $outgoingCallsToday = CallHistory::where('type', 'Outgoing')->where('employee_id', $employee_id)->whereDate('created_at', $today)->count();
   $missedCallsToday = CallHistory::where('type', 'Missed')->where('employee_id', $employee_id)->whereDate('created_at', $today)->count();
   $todayCalls = CallHistory::whereDate('created_at', $today)->where('employee_id', $employee_id)->count();

   


     return response()->json([
            'total' => $todayCalls,
            'outgoing' => $outgoingCallsToday,
            'incoming' => $incomingCallsToday,
            'missed' => $missedCallsToday,
        ]);
        

}


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
            // 'data' => $sale 
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
    ->limit(5)
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
        ->limit(5)
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
} 





