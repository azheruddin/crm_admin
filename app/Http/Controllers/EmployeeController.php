<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Leads;
use App\Models\CallHistory;
use Carbon\Carbon;


class EmployeeController extends Controller
{
    public function createEmployee(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees',
            'phone' => 'nullable|string|max:20',
            'type' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            // Add validation rules for other fields here
        ]);

        // Create a new employee instance with the validated data
        $employee = Employee::create($validatedData);

        // Redirect or return a response as needed
        $request->session()->flash('success', 'Employee added successfully.');
        return view('addEmployee')->with('success', 'Employee added successfully.');

    }


// show employees method 
public function showEmployees()
{
    $employees = Employee::all();
    return view('showEmployee')->with('employees', $employees);
}


// show employees method 
public function employeeDetail(Request $request)
{
    // $employee = Employee::where('id', $request->employee_id);
    $employee = Employee::findOrFail($request->employee_id);
   
    return view('employeeDetails')->with('employee', $employee);
}

// employee update method
public function edit($id)
{
    $employee = Employee::findOrFail($id);
    return view('employeeUpdate', compact('employee'));
}

public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:employees,email,' . $id,
        'phone' => 'required|string|max:20',
        'type' => 'required|string',
        'password' => 'nullable|string|min:8',
    ]);

    $employee = Employee::findOrFail($id);
    $employee->name = $validatedData['name'];
    $employee->email = $validatedData['email'];
    $employee->phone = $validatedData['phone'];
    $employee->type = $validatedData['type'];
    $employee->password =  $validatedData['password'];

    
    // if ($request->filled('password')) {
    //     $employee->password = Hash::make($request->password);
    // }

    $employee->save();
    $request->session()->flash('success', 'Employee update successfully.');
    return redirect()->route('show_employee')->with('success', 'Employee updated successfully.');
}

public function toggleActive($id)
{
    $employee = Employee::findOrFail($id);
    $employee->is_active = !$employee->is_active;  // Toggle the status
    $employee->save();

    return redirect()->route('show_employee')->with('success', 'Employee status updated successfully');
}

// Employee Delete Code
public function destroy($id)
{
    $employee = Employee::findOrFail($id);
    $employee->delete();

    return redirect()->route('show_employee')->with('success', 'Employee deleted successfully');
}


// Controller: EmployeeController.php
public function countEmployees()
    {
        // Fetch the counts for total, active, and deactivated employees
        $totalEmployees = Employee::count();
        $activeEmployees = Employee::where('is_active', 1)->count();
        $deactivatedEmployees = Employee::where('is_active', 0)->count();
    
        // Get today's date
        $today = Carbon::today();
    
        // Fetch the counts for different call types created today
        $incomingCallsToday = CallHistory::where('call_type', 'Incoming')->whereDate('created_at', $today)->count();
        $outgoingCallsToday = CallHistory::where('call_type', 'Outgoing')->whereDate('created_at', $today)->count();
        $missedCallsToday = CallHistory::where('call_type', 'Missed')->whereDate('created_at', $today)->count();
        $todayCalls = CallHistory::whereDate('created_at', $today)->count();

        // leads
        $totalLeads = Leads::whereDate('created_at', $today)->count();
        $hotLeads = Leads::where('lead_stage', 'hot')->whereDate('created_at', $today)->count();
        $interested = Leads::where('lead_stage', 'hot')->whereDate('created_at', $today)->count();
        $notInterested = Leads::where('lead_stage', 'hot')->whereDate('created_at', $today)->count();
       
    
        // Return the view with the counts
        return view('dashboard', compact('totalEmployees', 'activeEmployees', 'deactivatedEmployees', 'incomingCallsToday', 'outgoingCallsToday', 'missedCallsToday', 'todayCalls', 'totalLeads', 'hotLeads', 'interested', 'notInterested'));
    }

    public function toggleActives($id)
    {
        // Find the employee by ID and toggle the active status
        $employee = Employee::findOrFail($id);
        $employee->is_active = !$employee->is_active;
        $employee->save();

        // Redirect back with a success message
        return redirect()->route('dashboard')->with('success', 'Employee status updated successfully');
    }

}
