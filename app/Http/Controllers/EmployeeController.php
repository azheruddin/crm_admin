<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Leads;
use App\Models\CallHistory;
use App\Models\State;
use App\Models\City;
use Carbon\Carbon;


class EmployeeController extends Controller
{
    public function createEmployee(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:20',
            'type' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            // Add validation rules for other fields here
        ]);

        
    $existEmployee = Employee::where('phone', $validatedData['phone'])->first();
    if($existEmployee){

        $request->session()->flash('success', 'Phone number already exist.');
        return view('addEmployee')->with('success', 'Employee added successfully.');
    }else{

        // Create a new employee instance with the validated data
        $employee = Employee::create($validatedData);

        // Redirect or return a response as needed
        $request->session()->flash('success', 'Employee added successfully.');
        return view('addEmployee')->with('success', 'Employee added successfully.');
    }
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


    public function toggleActives($id)
    {
        // Find the employee by ID and toggle the active status
        $employee = Employee::findOrFail($id);
        $employee->is_active = !$employee->is_active;
        $employee->save();

        // Redirect back with a success message
        return redirect()->route('dashboard')->with('success', 'Employee status updated successfully');
    }

    
    public function showCallerEmployee(Request $request)
    {
    
    $employees = Employee::where('is_active', '1')->where('type', 'caller')->get();

    $States = State::get(); 
    // Return view with filtered call histories and active employees
    $Cities = City::get(); // Fetch all cities from the database

    return view( 'assignLeads', compact( 'employees', 'States','Cities'));
    }

    
/////////////////
public function editPassword($id)
{
    $employee = Employee::findOrFail($id);
    return view('updatePassword', compact('employee'));
}

public function updatePassword(Request $request, $id)
{
    $validatedData = $request->validate([
     
        'password' => 'nullable|string',
    ]);

    $employee = Employee::findOrFail($id);
    
    $employee->password =  $validatedData['password'];

    

    $employee->save();
    $request->session()->flash('success', 'Password Change successfully.');
    return redirect()->route('show_employee')->with('success', 'Password Change successfully.');
}

/////////////////////////////////////

}