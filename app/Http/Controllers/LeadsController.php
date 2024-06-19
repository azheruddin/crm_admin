<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leads;
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
            'lead_stage' => 'required|string|max:255',
            
            // Add validation rules for other fields here
        ]);

        // Create a new employee instance with the validated data
        $leads = Leads::create($validatedData);

        // Redirect or return a response as needed
        $request->session()->flash('success', 'Leads added successfully.');
        return view('addLeads')->with('success', 'Leads added successfully.');

    }

    



    

    
}


    
       
    

