<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leads;
use App\Models\Employee;
use App\Http\Controllers\Excel;


class LeadsController extends Controller
{
    

    public function showLeadsFeedback()
    {
        $leadsFeedback = Leads::orderBy('id','desc')->get(); // Use the Leads model here
        return view('LeadsFeedback')->with('LeadsFeedback', $leadsFeedback);
        
    }

   
public function leadsFeedbackByEmployee(Request $request)
{
    $leadsFeedbackByEmployee = Leads::where('employee_id', $request->employee_id)->orderBy('id', 'desc');
    return view('LeadsFeedbackByEmployee')->with('LeadsFeedbackByEmployee', $leadsFeedbackByEmployee);
}



public function showUploadForm()
{
    return view('upload');
}

public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv',
    ]);

    Excel::import(new LeadsImport, $request->file('file'));

    return back()->with('success', 'Leads imported successfully.');
}


public function leadsFeedbackDetail(Request $request)
{
    $leads = Leads::findOrFail($request->lead_id);
   
    return view('leadsDetails')->with('leads', $leads);
}


public function todayLeads()
    {
        // Fetch today's leads
        $todayLeads = Leads::whereDate('created_at', now()->toDateString())->get();

        // Pass the leads to the view
        return view('todayLeads', compact('todayLeads'));
    }

 
    public function filterLeads(Request $request)
    {
        // Get the date range from the request
        $fromDate = $request->input('from_date', now()->startOfDay());
        $toDate = $request->input('to_date', now()->endOfDay());

        // Fetch leads within the specified date range
        $todayLeads = Leads::whereBetween('created_at', [$fromDate, $toDate])->get();


        // Pass the leads and date range inputs to the view
        return view('todayLeads', compact('todayLeads', 'fromDate', 'toDate'));
    }

    public function createLeads(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|string|email|max:255|unique:leads',
            'phone' => 'nullable|string|max:20',
            'state' => 'required|string|max:255', // Add validation rule for state
            'city' => 'required|string|max:255', // Add validation rule for city
            
            // Add validation rules for other fields here
        ]);

        // Create a new employee instance with the validated data
        $leads = Leads::create($validatedData);

        // Redirect or return a response as needed
        $request->session()->flash('success', 'Leads added successfully.');
        return view('addLeads')->with('success', 'Leads added successfully.');

    }

    



    

    
    public function filterLeadsByEmployee(Request $request)
    {
        $validatedData = $request->validate([
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date',
            'employee_id' => 'nullable|integer',
        ]);
    $query = Leads::with('employee');

    // Filter by from_date if provided
    if ($request->filled('from_date')) {
        $query->whereDate('created_at', '>=', $validatedData['from_date']);
    }

    // Filter by to_date if provided
    if ($request->filled('to_date')) {
        $query->whereDate('created_at', '<=', $validatedData['to_date']);
    }

    // Filter by employee_id if provided
    if ($request->filled('employee_id')) {
        $query->where('employee_id', $validatedData['employee_id']);
    }

    // Retrieve filtered call histories ordered by id desc
    $LeadsFeedback = $query->where('is_deleted', 0)->orderBy('id', 'desc')->get();

    

    // Load active callers
    $employees = Employee::where('is_active', '1')->where('type', 'caller')->get();

    // Return view with filtered call histories and active employees
    return view('LeadsFeedback', compact('LeadsFeedback', 'employees'));
}

//code for delete leads


public function deleteLeads(Request $request)
    {
        // Retrieve all employees for the filter dropdown
        $employees = Employee::all();

        // Prepare the base query for fetching leads
        $query = Leads::query()->where('is_deleted', 1);

        // Apply filters if provided in the request
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
            
        }

        // Fetch the leads with employee relations
        $LeadsFeedback = $query->with('employee')->get();

        // Return the view with leads and employees data
        return view('deleteLeads', compact('LeadsFeedback', 'employees'));
    }

    public function deleteLead($lead_id)
    {
        // Soft delete the lead
        Leads::findOrFail($lead_id)->delete();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Lead deleted successfully!');
    }

}
