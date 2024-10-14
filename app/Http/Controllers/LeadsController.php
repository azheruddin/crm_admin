<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leads;
use App\Models\Employee;
use App\Http\Controllers\Excel;
use App\Models\State;
use App\Models\City;
use Carbon\Carbon; // Import Carbon class
use Illuminate\Support\Facades\DB;





class LeadsController extends Controller
{
    

    public function showLeadsFeedback()
    {
        $leadsFeedback = Leads::orderBy('id','desc')->get(); // Use the Leads model here
        return view('LeadsFeedback')->with('LeadsFeedback', $leadsFeedback);
        
    }
    public function new_leads_show(Request $request)
    {
        
        $LeadsFeedback = Leads::orderBy('id','desc')->where('lead_stage', 'NEW')->get();
        
        if ($request->has('employee_id') && $request->employee_id != '') {
        $LeadsFeedback =  $LeadsFeedback->where('employee_id', $request->employee_id);
        }
        // Load active callers
    $employees = Employee::where('is_active', '1')->where('type', 'caller')->get();
        return view('newLeads', compact('LeadsFeedback', 'employees'));
        
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


// public function todayLeads()
//     {
//         // Fetch today's leads
//         $todayLeads = Leads::whereDate('created_at', now()->toDateString())->get();

//         // Pass the leads to the view
//         return view('todayLeads', compact('todayLeads'));
//     }

 
    // public function filterLeads(Request $request)
    // {
    //     // Get the date range from the request
    //     $fromDate = $request->input('from_date', now()->startOfDay());
    //     $toDate = $request->input('to_date', now()->endOfDay());

    //     // Fetch leads within the specified date range
    //     $todayLeads = Leads::whereBetween('created_at', [$fromDate, $toDate])->get();


    //     // Pass the leads and date range inputs to the view
    //     return view('todayLeads', compact('todayLeads', 'fromDate', 'toDate'));
    // }
    
    
    
public function todayLeads()
    {
        // Fetch today's leads
        $todayLeads = Leads::whereDate('updated_at', now()->toDateString())
        ->where('lead_stage','!=', "NEW")
        ->get();
        
        $employees = Employee::where('is_active', 1)->get();

        // Pass the leads to the view
        return view('todayLeads', compact('todayLeads', 'employees'));
    }
    
    
    
//     public function filterLeads(Request $request)
//     {
//         $employee_id = $request->employee_id;
        
//         $query = Leads::with('employee')->whereDate('updated_at', now()->toDateString());
        
//         $query->where('lead_stage','!=', "NEW");  


// // Filter by employee_id if provided
//          if ($request->filled('employee_id')) {
//         $query->where('employee_id', $employee_id);  
//       }

//      $todayLeads = $query->get();

//       $employees = Employee::where('is_active', 1)->get();

//         // Pass the leads and date range inputs to the view
//         return view('todayLeads', compact('todayLeads', 'employees'));
//     }

public function filterLeads(Request $request)
{
    // Retrieve employee list for the dropdown
    $employees = Employee::all();

    // Initialize query
    $query = Leads::with('employee')
    ->where('lead_stage','!=', "NEW")
    ->whereDate('updated_at', now()->toDateString());

    // Apply filters
   

    if ($request->has('employee_id') && $request->employee_id != '') {
        $query->where('employee_id', $request->employee_id);
    }

    if ($request->has('lead_stage') && $request->lead_stage != '') {
        $query->where('lead_stage', $request->lead_stage);
    }

    // Fetch filtered leads
    // $todayLeads = $query->get();
    $todayLeads = $query->get();  // Leads::whereDate('updated_at', now()->toDateString())->get();

    // Return view with filtered leads and employees
    return view('todayLeads', compact('todayLeads', 'employees'));
}
    
    
    


    

    // public function createLeads(Request $request)
    // {
    //     $States = State::get(); 
                
    //     // $validatedData = $request->validate([
    //     //     'customer_name' => 'required|string|max:255',
    //     //     'customer_email' => 'required|email|max:255',
    //     //     'phone' => 'required|numeric',
    //     //     'state_id' => 'required|exists:state,id',
    //     //     'city_id' => 'required|exists:city,id',
    //     // ]);

    //     // $lead = Leads::create($validatedData);
        
    //     $lead = Leads::create([
    //         'customer_name' => $request['customer_name'],
    //         'customer_email' => $request['customer_email'],
    //         'phone' => $request['phone'],
    //         'state' => $request['state'],
    //         'city' => $request['city'],
    //     ]);
        

    //     $request->session()->flash('success', 'Leads added successfully.');

    //     return view('addLeads', compact('States'))->with('success', 'Leads added successfully.');

        
    // }


    public function createLeads(Request $request)
    {
        // Assuming you fetch States from your database
        $States = State::get(); // Fetch states here
    
        // Proceed with your code
        $lead = Leads::create([
            'customer_name' => $request['customer_name'],
            'customer_email' => $request['customer_email'],
            'phone' => $request['phone'],
            'state' => $request['state'],
            'city' => $request['city'],
        ]);
    
        $request->session()->flash('success', 'Leads added successfully.');
    
        // Pass $States to the view
        return view('addLeads', compact('States'));
    }

    public function filterLeadsByEmployee(Request $request)
    {
        // Fetch all active employees who are callers
        $employees = Employee::where('is_active', '1')->where('type', 'caller')->get();
    
        // Fetch employee_id, from_date, and to_date from the request
        $employee_id = $request->employee_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
    
        // If employee_id or date range is missing, return empty data
        if (!$employee_id || !$from_date || !$to_date) {
            return view('LeadsFeedback', [
                'employees' => $employees,
                'LeadsFeedback' => collect() // Return an empty collection
            ]);
        }
    
        // Convert dates to Carbon instances
        $startOfDay = Carbon::parse($from_date)->startOfDay();
        $endOfDay = Carbon::parse($to_date)->endOfDay();
    
        // Build the query for Leads
        $query = Leads::query()->with('employee')
            ->where('is_deleted', 0)
            ->whereBetween('created_at', [$startOfDay, $endOfDay]);
    
        // Filter by employee_id if provided
        if ($employee_id) {
            $query->where('employee_id', $employee_id);
        }
    
        // Retrieve the filtered leads
        $LeadsFeedback = $query->orderBy('id', 'desc')->get();
    
        // Pass $employees and $LeadsFeedback to the view
        return view('LeadsFeedback', [
            'employees' => $employees,
            'LeadsFeedback' => $LeadsFeedback
        ]);
    }
    
///////////////////



////////////////////
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




// public function assignleadsToEmployee(Request $request)
// {
//     // Validate the request data
//     $validatedData = $request->validate([
//         'employee_id' => 'required|integer',
//         'state' => 'required|string|max:255',
//         'city' => 'required|string|max:255',
//     ]);

//     // Find the leads that match the given city and state and employee id is null
//     $leads = Leads::where('city', $validatedData['city'])
//                   ->where('state', $validatedData['state'])
//                   ->where('employee_id', null)
//                   ->get();
                                       
//     // Check if any leads are found
//     if ($leads->isEmpty()) {
//         $request->session()->flash('success', 'No leads found found.');
//         return redirect()->back()->with('error', 'No leads found found.');
//     }

//     // Update the employee_id for each lead found
//     foreach ($leads as $lead) {
//         $lead->employee_id = $validatedData['employee_id'];
//         $lead->save();
//     }
    

//     // Redirect or return a response as needed
//     $request->session()->flash('success', 'Leads updated successfully.');
//     return redirect()->back()->with('success', 'Leads updated successfully.');
// }

// public function assignLeads(Request $request)
// {
//     // Handle the lead assignment logic here
//     // Example: Lead::create($request->all());
//     return redirect()->route('assign_leads')->with('success', 'Lead assigned successfully');
// }

public function assignleadsToEmployee(Request $request)
{
    // Validate the request data
    $validatedData = $request->validate([
        'employee_id' => 'required|integer',
        'state_id' => 'required|integer',
        'city_id' => 'required|integer',
    ]);

    // Retrieve state and city names based on IDs
    $state = State::find($validatedData['state_id']);
    $city = City::find($validatedData['city_id']);

    // Check if state and city exist
    if (!$state || !$city) {
        return redirect()->back()->with('error', 'Invalid state or city ID.');
    }

    // Find the leads that match the given city and state
    $leads = Leads::where('city', $city->city_name)
                  ->where('state', $state->state_name)
                  ->where('employee_id', null)
                  ->get();
                                       
    // Check if any leads are found
    if ($leads->isEmpty()) {
        $request->session()->flash('success', 'No leads found.');
        return redirect()->back()->with('error', 'No leads found.');
    }

    // Update the employee_id for each lead found
    foreach ($leads as $lead) {
        $lead->employee_id = $validatedData['employee_id'];
        $lead->save();
    }

    return redirect()->back()->with('success', 'Leads assigned successfully.');
}



public function showLeads(Request $request)
{ 

$States = State::get(); 
// Return view with filtered call histories and active employees
$Cities = City::get(); // Fetch all cities from the database

return view( 'addLeads', compact(  'States','Cities'));
}




public function getCities($state_id)
{
    $cities = City::where('state_id', $state_id)->get();
    return response()->json($cities);
}


public function leadsReview($id)
    {
        // Fetch the lead review by ID
        $lead_review = Lead_review::find($id);

        // Check if the lead review exists
        if (!$lead_review) {
            return redirect()->back()->with('error', 'Lead Review not found');
        }
        
        // Pass the lead review to the view
        return view('leadsDetails', compact('lead_review'));
    }

    // public function countLeads(Request $request)
    // {
    //     $employeeId = $request->get('employee_id');
    
    //     $employees = Employee::withCount([
    //         'leads as all' => function ($query) {
    //             // Add your query logic here
    //         },
    //         'leads as newLeads' => function ($query) {
    //             $query->where('lead_stage', 'NEW');
    //         },
    //         // Add more lead counts here as needed
    //     ]);
    
    //     // If employee filter is selected, apply the filter to the query
    //     if (!empty($employeeId)) {
    //         $employees->where('id', $employeeId);
    //     }
    
    //     $employees = $employees->get();
    
    //     return view('countLeads', compact('employees'));
    // }



//     public function countLeads(Request $request)
// {
//     $employeeId = $request->get('employee_id');

//     $employees = Employee::withCount([
//         'leads as all' => function ($query) {
//             // Count all leads 
//             $query->whereNotNull('id');
//         },
//         'leads as newLeads' => function ($query) {
//             $query->where('lead_stage', 'NEW');
//         },
//         'leads as todayUploads' => function ($query) {
//             $query->whereDate('created_at', Carbon::today());
//         },
//         'leads as followUpLeads' => function ($query) {
//             $query->where('lead_stage', 'FOLLOW UP');
//         },
//         'leads as hotLeads' => function ($query) {
//             $query->where('lead_stage', 'HOT');
//         },
//         'leads as interestedLeads' => function ($query) {
//             $query->where('lead_stage', 'INTERESTED');
//         },
//         'leads as notAnsweredLeads' => function ($query) {
//             $query->where('lead_stage', 'NOT ANSWERED');
//         },
//         'leads as notInterestedLeads' => function ($query) {
//             $query->where('lead_stage', 'NOT INTERESTED');
//         },
//         'leads as closeLeads' => function ($query) {
//             $query->where('lead_stage', 'CLOSED');
//         },
//     ]);

//     // If employee filter is selected, apply the filter to the query
//     if (!empty($employeeId)) {
//         $employees->where('id', $employeeId);
//     }

//     $employees = $employees->get();

//     return view('countLeads', compact('employees'));
// }



public function countLeads(Request $request)
{
    $employeeId = $request->get('employee_id');

    $employees = Employee::withCount([
        'leads as all' => function ($query) {
            // Count all leads
            $query->whereNotNull('id');
        },
        'leads as newLeads' => function ($query) {
            $query->where('lead_stage', 'NEW');
        },
        'leads as todayUploads' => function ($query) {
            $query->whereDate('created_at', Carbon::today());
        },
        'leads as followUpLeads' => function ($query) {
            $query->where('lead_stage', 'FOLLOW UP');
        },
        'leads as hotLeads' => function ($query) {
            $query->where('lead_stage', 'HOT');
        },
        'leads as interestedLeads' => function ($query) {
            $query->where('lead_stage', 'INTERESTED');
        },
        'leads as notAnsweredLeads' => function ($query) {
            $query->where('lead_stage', 'NOT ANSWERED');
        },
        'leads as notInterestedLeads' => function ($query) {
            $query->where('lead_stage', 'NOT INTERESTED');
        },
        'leads as closeLeads' => function ($query) {
            $query->where('lead_stage', 'CLOSED');
        },
    ]);

    // If employee filter is selected, apply the filter to the query
    if (!empty($employeeId)) {
        $employees->where('id', $employeeId);
    }

    // Sort by today's uploads count in descending order
    $employees->orderBy('todayUploads', 'desc');

    $employees = $employees->get();

    $employeesSelect = Employee::where('is_active', '1')->where('type', 'caller')->get();


    return view('countLeads', compact('employees','employeesSelect'));
}

    
public function deleteLeads($id, Request $request)
{
    // Find the lead by ID
    $lead = Leads::find($id);

    if ($lead) {
        $lead->delete(); // Delete the lead
        $request->session()->flash('success', 'Lead deleted successfully.');
    } else {
        $request->session()->flash('error', 'Lead not found.');
    }

    // Redirect back or to a specific view
    return redirect()->back();
}



}