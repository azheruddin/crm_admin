<?php

namespace App\Http\Controllers;

use App\Models\CallHistory;
use App\Models\Leads;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;  // read about this on google
// use Illuminate\Support\Facades\Hash;


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


// show leads by employee
public function lead_by_employee(Request $request){
    $leads=  Leads::where('employee_id', $request->employee_id)->orderBy('id', 'desc')->get();
    $data_record = array();
    foreach ($leads as $row) {
     
       $data_record[] = [
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
   $array = json_encode($data_record);
   $array = json_decode($array);
    if ($leads != null && $request->employee_id != null) {
       return response()->json([
           'status' => 'S',
           'data' => $array,

       ], 200, [], JSON_NUMERIC_CHECK);
   } else {
       return response()->json(['status' => 'F', 'errorMsg' => 'data Not found'], 200);
   }
}
}
