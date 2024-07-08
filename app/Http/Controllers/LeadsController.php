<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leads;
use App\Models\Employee;
use App\Http\Controllers\Excel;
use App\Models\State;
use App\Models\City;
use Carbon\Carbon; // Import Carbon class




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
                
        // $validatedData = $request->validate([
        //     'customer_name' => 'required|string|max:255',
        //     'customer_email' => 'required|email|max:255',
        //     'phone' => 'required|numeric',
        //     'state_id' => 'required|exists:state,id',
        //     'city_id' => 'required|exists:city,id',
        // ]);

        // $lead = Leads::create($validatedData);
        
        $lead = Leads::create([
            'customer_name' => $request['customer_name'],
            'customer_email' => $request['customer_email'],
            'phone' => $request['phone'],
            'state' => $request['state'],
            'city' => $request['city'],
        ]);
        $States = State::get(); 

        $request->session()->flash('success', 'Leads added successfully.');

        return view('addLeads', compact('States'))->with('success', 'Leads added successfully.');

        
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


public function showdeleteLeads(Request $request)
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
        return view('showdeleteLeads', compact('LeadsFeedback', 'employees'));
    }

    public function deleteLead($lead_id)
    {
        // Soft delete the lead
        Leads::findOrFail($lead_id)->delete();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Lead deleted successfully!');
    }


    public function showdeleteleadsDetail(Request $request)
{
    $leads = Leads::findOrFail($request->lead_id);
   
    return view('showdeleteleadsDetails')->with('leads', $leads);
}




public function assignleadsToEmployee(Request $request)
{
    // Validate the request data
    $validatedData = $request->validate([
        'employee_id' => 'required|integer',
        'state' => 'required|string|max:255',
        'city' => 'required|string|max:255',
    ]);

    // Find the leads that match the given city and state
    $leads = Leads::where('city', $validatedData['city'])
                  ->where('state', $validatedData['state'])
                  ->get();

    // Check if any leads are found
    if ($leads->isEmpty()) {
        return redirect()->back()->with('error', 'No leads found for the specified city and state.');
    }

    // Update the employee_id for each lead found
    foreach ($leads as $lead) {
        $lead->employee_id = $validatedData['employee_id'];
        $lead->save();
    }

    // Redirect or return a response as needed
    $request->session()->flash('success', 'Leads updated successfully.');
    return redirect()->back()->with('success', 'Leads updated successfully.');
}

public function assignLeads(Request $request)
{
    // Handle the lead assignment logic here
    // Example: Lead::create($request->all());
    return redirect()->route('assign_leads')->with('success', 'Lead assigned successfully');
}




public function showLeads(Request $request)
{ 


$States = State::get(); 
// Return view with filtered call histories and active employees
$Cities = City::get(); // Fetch all cities from the database

return view( 'addLeads', compact(  'States','Cities'));
}



/////////////////////////////////////////////////////////////////////

public function getCities($state_id)
{
    $cities = City::where('state_id', $state_id)->get();
    return response()->json($cities);
}


}
