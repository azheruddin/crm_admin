<?php

namespace App\Http\Controllers;

use App\Models\CallHistory;
use App\Models\Leads;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;  // read about this on google
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

//        ], 200, [], JSON_NUMERIC_CHECK);
//    } else {
//        return response()->json(['status' => 'F', 'errorMsg' => 'data Not found'], 200);
//    }
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
    $query = Leads::where('employee_id', $request->employee_id)
                  ->where('is_deleted', 0)
                  ->whereNotNull('next_follow_up')
                  ->where('next_follow_up', '>=', now())
                  ->orderBy('id', 'desc')
                  ->get();

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



}
