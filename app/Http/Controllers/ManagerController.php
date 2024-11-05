<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class ManagerController extends Controller
{
    //
//     public function createManager(Request $request)
//     {
//         // Validate the request data
//         $validatedData = $request->validate([
//             'name' => 'required|string|max:255',
//             'email' => 'required|string|email|max:255',
//             'phone' => 'nullable|string|max:20',
//             'password' => 'required|string|max:255',
//             // Add validation rules for other fields here
//         ]);

        
//     $existEmployee = Employee::where('phone', $validatedData['phone'])->first();
//     if($existEmployee){

//         $request->session()->flash('success', 'Phone number already exist.');
//         return view('addManager')->with('success', 'Employee added successfully.');
//     }else{

//         $validatedData['type'] = 'manager';

//         // Create a new employee instance with the validated data
//         $employee = Employee::create($validatedData);

//         // Redirect or return a response as needed
//         $request->session()->flash('success', 'Manager added successfully.');
//         return view('addManager')->with('success', 'Mangaer added successfully.');
//     }
//     }


// // show employees method 
// public function showManager()
// {
//     $employees = Employee::where('type', 'manager')->get();
//     return view('showEmployee')->with('employees', $employees);
// }
            



public function createManager(Request $request)
{
    // Get the authenticated admin ID
    $admin_id = auth()->id();

    // Validate the request data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'phone' => 'nullable|string|max:20',
        'password' => 'required|string|max:255',
        // Add validation rules for other fields here
    ]);

    // Check if the phone number already exists in the database
    $existEmployee = Employee::where('phone', $validatedData['phone'])->first();

    if ($existEmployee) {
        $request->session()->flash('success', 'Phone number already exists.');
        return view('addManager')->with('success', 'Employee already exists.');
    } else {
        // Add type as 'manager' and admin_id to the validated data
        $validatedData['type'] = 'manager';
        $validatedData['admin_id'] = $admin_id; // Store the admin_id

        // Create a new employee instance with the validated data
        $employee = Employee::create($validatedData);

        // Redirect or return a response as needed
        $request->session()->flash('success', 'Manager added successfully.');
        return view('addManager')->with('success', 'Manager added successfully.');
    }
}

public function showManager()
{
    // Get the authenticated admin ID
    $admin_id = auth()->id();

    // Fetch managers associated with the authenticated admin
    $employees = Employee::where('type', 'manager')->where('admin_id', $admin_id)->get();  

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

    ]);

    $employee = Employee::findOrFail($id);
    $employee->name = $validatedData['name'];
    $employee->email = $validatedData['email'];
    $employee->phone = $validatedData['phone'];  
    $employee->type = $validatedData['type'];

    
    // if ($request->filled('password')) {
    //     $employee->password = Hash::make($request->password);
    // }

    $employee->save();
    $request->session()->flash('success', 'Employee update successfully.');
    return redirect()->route('show_employee')->with('success', 'Employee updated successfully.');
}


}
