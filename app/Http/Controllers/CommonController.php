<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leads;
use App\Models\Employee;
use App\Models\CallHistory;
use Carbon\Carbon;

class CommonController extends Controller
{
    public function dashBoardCounts()
    {
        // Fetch the counts for total, active, and deactivated employees
        $totalEmployees = Employee::count();
        $activeEmployees = Employee::where('is_active', 1)->count();
        $deactivatedEmployees = Employee::where('is_active', 0)->count();
    
        // Get today's date
        $today = Carbon::today();
    
        // Fetch the counts for different call types created today
        $incomingCallsToday = CallHistory::where('type', 'Incoming')->whereDate('created_at', $today)->count();
        $outgoingCallsToday = CallHistory::where('type', 'Outgoing')->whereDate('created_at', $today)->count();
        $missedCallsToday = CallHistory::where('type', 'Missed')->whereDate('created_at', $today)->count();
        $unknownCallsToday = CallHistory::where('type', 'Unknown')->whereDate('created_at', $today)->count();

        $todayCalls = CallHistory::whereDate('created_at', $today)->count();

        // leads
        $totalLeads = Leads::whereDate('created_at', $today)->count();
        $hotLeads = Leads::where('lead_stage', 'hot')->whereDate('created_at', $today)->count();
        $interested = Leads::where('lead_stage', 'interested')->whereDate('created_at', $today)->count();
        $notInterested = Leads::where('lead_stage', 'not_interested')->whereDate('created_at', $today)->count();
       
    
        // Return the view with the counts
        return view('dashboard', compact('totalEmployees', 'activeEmployees', 'deactivatedEmployees', 'incomingCallsToday', 'outgoingCallsToday', 'missedCallsToday','unknownCallsToday', 'todayCalls', 'totalLeads', 'hotLeads', 'interested', 'notInterested'));
    }


    


   

    
}

