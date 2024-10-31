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
        $admin_id = auth()->id();

        $totalEmployees = Employee::where('admin_id', $admin_id)->count();
        $activeEmployees = Employee::where('is_active', 1)->where('admin_id', $admin_id)->count();
        $deactivatedEmployees = Employee::where('is_active', 0)->where('admin_id', $admin_id)->count();
    
        // Get today's date
        $today = Carbon::today();
    
        // // Fetch the counts for different call types created today
        // $incomingCallsToday = CallHistory::where('type', 'Incoming')->whereDate('created_at', $today)->count();
        // $outgoingCallsToday = CallHistory::where('type', 'Outgoing')->whereDate('created_at', $today)->count();
        // $missedCallsToday = CallHistory::where('type', 'Missed')->whereDate('created_at', $today)->count();
        // $unknownCallsToday = CallHistory::where('type', 'Unknown')->whereDate('created_at', $today)->count();

        // $todayCalls = CallHistory::whereDate('created_at', $today)->count();
        ////////////
       

    // Get unique incoming calls
    $incoming = CallHistory::where('type', 'Incoming')
    // ->where('employee_id', $employee_id)
    ->whereDate('created_at', $today)
    ->whereHas('employee', function ($query) use ($admin_id) {
        $query->where('admin_id', $admin_id); // Filter employees by admin_id
    })
    ->select(DB::raw('COUNT(DISTINCT CONCAT(phone, "-", call_duration)) as unique_count'))
    ->pluck('unique_count')
    ->first();


        $uniqueOutgoingCallsToday = CallHistory::where('type', 'Outgoing')
        ->whereHas('employee', function ($query) use ($admin_id) {
            $query->where('admin_id', $admin_id); // Filter employees by admin_id
        })
        // ->where('employee_id', $employee_id)
        ->whereDate('created_at', $today)
       
        ->select(DB::raw('COUNT(DISTINCT CONCAT(phone, "-", call_duration)) as unique_count'))
        ->pluck('unique_count')
       
        ->first();

    // Get missed calls
    $missed = CallHistory::where('type', 'Missed')
        // ->where('employee_id', $employee_id)
        ->whereDate('created_at', $today)
        ->whereHas('employee', function ($query) use ($admin_id) {
            $query->where('admin_id', $admin_id); // Filter employees by admin_id
        })
        ->count();

    // Get unknown calls
    $unknown = CallHistory::where('type', 'Unknown')
        // ->where('employee_id', $employee_id)
        ->whereDate('created_at', $today)
        ->whereHas('employee', function ($query) use ($admin_id) {
            $query->where('admin_id', $admin_id); // Filter employees by admin_id
        })
        ->select(DB::raw('COUNT(DISTINCT CONCAT(phone, "-", call_duration)) as unique_count'))
        ->pluck('unique_count')
       
        ->first();

    // Calculate total calls
    $total = $incoming + $uniqueOutgoingCallsToday +  $missed + $unknown;
        //////////////////////

        $admin_id = auth()->id();

        // leads
        // $totalLeads = Leads::whereDate('updated_at', $today)->where('lead_stage', '!=', 'new')->count();
        $hotLeads = Leads::where('lead_stage', 'hot')->where('admin_id', $admin_id)->whereDate('updated_at', $today)->where('lead_stage', '!=', 'new')->count();
        $interested = Leads::where('lead_stage', 'interested')->where('admin_id', $admin_id)->whereDate('updated_at', $today)->where('lead_stage', '!=', 'new')->count();
        $notInterested = Leads::where('lead_stage', 'not_interested')->where('admin_id', $admin_id)->whereDate('updated_at', $today)->where('lead_stage', '!=', 'new')->count();
        $notAnswered = Leads::where('lead_stage', 'not_answered')->where('admin_id', $admin_id)->whereDate('created_at', $today)->count();
        $close = Leads::where('lead_stage', operator: 'close')->where('admin_id', $admin_id)->whereDate('created_at', $today)->count();
        $todaysUploadedLeads = Leads::where('admin_id', $admin_id)->whereDate('created_at', $today)->count();
         $totalLeads = $hotLeads + $interested + $notInterested + $close + $notAnswered ;
       
    
        // Return the view with the counts
        return view('dashboard', compact('totalEmployees', 'activeEmployees', 'deactivatedEmployees','totalLeads', 'hotLeads', 'interested', 'notInterested','uniqueOutgoingCallsToday', 'incoming', 'missed','unknown', 'total', 'notAnswered', 'close', 'todaysUploadedLeads'));
    }


   
}
    

