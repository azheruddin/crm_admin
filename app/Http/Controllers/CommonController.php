<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leads;
use App\Models\Employee;
use App\Models\CallHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;  // read about this on google


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
    
        // // Fetch the counts for different call types created today
        // $incomingCallsToday = CallHistory::where('type', 'Incoming')->whereDate('created_at', $today)->count();
        // $outgoingCallsToday = CallHistory::where('type', 'Outgoing')->whereDate('created_at', $today)->count();
        // $missedCallsToday = CallHistory::where('type', 'Missed')->whereDate('created_at', $today)->count();
        // $unknownCallsToday = CallHistory::where('type', 'Unknown')->whereDate('created_at', $today)->count();

        // $todayCalls = CallHistory::whereDate('created_at', $today)->count();
        ////////////
        $uniqueOutgoingCallsToday = CallHistory::where('type', 'Outgoing')
        // ->where('employee_id', $employee_id)
        ->whereDate('created_at', $today)
        ->select(DB::raw('COUNT(DISTINCT CONCAT(phone, "-", call_duration)) as unique_count'))
        ->pluck('unique_count')
        ->first();

    // Get unique incoming calls
    $incoming = CallHistory::where('type', 'Incoming')
        // ->where('employee_id', $employee_id)
        ->whereDate('created_at', $today)
        ->select(DB::raw('COUNT(DISTINCT CONCAT(phone, "-", call_duration)) as unique_count'))
        ->pluck('unique_count')
        ->first();

    // Get missed calls
    $missed = CallHistory::where('type', 'Missed')
        // ->where('employee_id', $employee_id)
        ->whereDate('created_at', $today)
        ->count();

    // Get unknown calls
    $unknown = CallHistory::where('type', 'Unknown')
        // ->where('employee_id', $employee_id)
        ->whereDate('created_at', $today)
        ->select(DB::raw('COUNT(DISTINCT CONCAT(phone, "-", call_duration)) as unique_count'))
        ->pluck('unique_count')
        ->first();

    // Calculate total calls
    $total = $uniqueOutgoingCallsToday + $incoming + $missed + $unknown;
        //////////////////////



        // leads
        $totalLeads = Leads::whereDate('created_at', $today)->count();
        $hotLeads = Leads::where('lead_stage', 'hot')->whereDate('created_at', $today)->count();
        $interested = Leads::where('lead_stage', 'interested')->whereDate('created_at', $today)->count();
        $notInterested = Leads::where('lead_stage', 'not_interested')->whereDate('created_at', $today)->count();
        $notAnswered = Leads::where('lead_stage', 'not_answered')->whereDate('created_at', $today)->count();
        $close = Leads::where('lead_stage', 'close')->whereDate('created_at', $today)->count();
       
    
        // Return the view with the counts
        return view('dashboard', compact('totalEmployees', 'activeEmployees', 'deactivatedEmployees','totalLeads', 'hotLeads', 'interested', 'notInterested','notAnswered','close','uniqueOutgoingCallsToday', 'incoming', 'missed','unknown', 'total'));
    }


    // public function calls_count(Request $request)
    // {
    //     // Get employee_id from request
    //     $employee_id = $request->input('employee_id');
        
    //     // Get today's date using Carbon
    //     $today = Carbon::today();

    //     // Fetch unique outgoing calls for the employee
    //     $uniqueOutgoingCallsToday = CallHistory::where('type', 'Outgoing')
    //         ->where('employee_id', $employee_id)
    //         ->whereDate('created_at', $today)
    //         ->select(DB::raw('COUNT(DISTINCT CONCAT(phone, "-", call_duration)) as unique_count'))
    //         ->pluck('unique_count')
    //         ->first();

    //     // Fetch unique incoming calls for the employee
    //     $incoming = CallHistory::where('type', 'Incoming')
    //         ->where('employee_id', $employee_id)
    //         ->whereDate('created_at', $today)
    //         ->select(DB::raw('COUNT(DISTINCT CONCAT(phone, "-", call_duration)) as unique_count'))
    //         ->pluck('unique_count')
    //         ->first();

    //     // Fetch missed calls for the employee
    //     $missed = CallHistory::where('type', 'Missed')
    //         ->where('employee_id', $employee_id)
    //         ->whereDate('created_at', $today)
    //         ->count();

    //     // Fetch unique unknown calls for the employee
    //     $unknown = CallHistory::where('type', 'Unknown')
    //         ->where('employee_id', $employee_id)
    //         ->whereDate('created_at', $today)
    //         ->select(DB::raw('COUNT(DISTINCT CONCAT(phone, "-", call_duration)) as unique_count'))
    //         ->pluck('unique_count')
    //         ->first(); 

    //     // Calculate the total number of calls
    //     $total = $uniqueOutgoingCallsToday + $uniqueincomingCallsToday + $uniquemissedCallsToday + $uniqueunknownCallsToday;

    //     // Pass the data to a Blade view
    //     return view('dashboard', [
    //         'total' => $total,
    //         'outgoing' => $uniqueOutgoingCallsToday,
    //         'incoming' => $uniqueincomingCallsToday,
    //         'missed' => $uniquemissedCallsToday,
    //         'unknown' => $uniqueunknownCallsToday,
    //     ]);
    // }

   
    // public function calls_count(Request $request)
    // {
    //     // $employee_id = $request->input('employee_id');
        
    //     // Get today's date
    //     $today = Carbon::today();

    //     // Get unique outgoing calls
    //     $uniqueOutgoingCallsToday = CallHistory::where('type', 'Outgoing')
    //         // ->where('employee_id', $employee_id)
    //         ->whereDate('created_at', $today)
    //         ->select(DB::raw('COUNT(DISTINCT CONCAT(phone, "-", call_duration)) as unique_count'))
    //         ->pluck('unique_count')
    //         ->first();

    //     // Get unique incoming calls
    //     $incoming = CallHistory::where('type', 'Incoming')
    //         // ->where('employee_id', $employee_id)
    //         ->whereDate('created_at', $today)
    //         ->select(DB::raw('COUNT(DISTINCT CONCAT(phone, "-", call_duration)) as unique_count'))
    //         ->pluck('unique_count')
    //         ->first();

    //     // Get missed calls
    //     $missed = CallHistory::where('type', 'Missed')
    //         // ->where('employee_id', $employee_id)
    //         ->whereDate('created_at', $today)
    //         ->count();

    //     // Get unknown calls
    //     $unknown = CallHistory::where('type', 'Unknown')
    //         // ->where('employee_id', $employee_id)
    //         ->whereDate('created_at', $today)
    //         ->select(DB::raw('COUNT(DISTINCT CONCAT(phone, "-", call_duration)) as unique_count'))
    //         ->pluck('unique_count')
    //         ->first();

    //     // Calculate total calls
    //     $total = $uniqueOutgoingCallsToday + $incoming + $missed + $unknown;

    //     // Pass data to the view
    //     return view('dashboard', [
    //         'total' => $total,
    //         'outgoing' => $uniqueOutgoingCallsToday,
    //         'incoming' => $incoming,
    //         'missed' => $missed,
    //         'unknown' => $unknown,
    //     ]);
    // }
}
    

