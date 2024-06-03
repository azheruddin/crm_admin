<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leads;
use App\Http\Controllers\Excel;


class LeadsController extends Controller
{
    

    // public function showLeadsFeedback()
    // {
    //     $leadsFeedback = LeadsFeedback::orderBy('id','desc')->get();
    //     return view('lead_calls')->with('LeadsFeedback' , $leadsFeedback);
    // } 


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

}
