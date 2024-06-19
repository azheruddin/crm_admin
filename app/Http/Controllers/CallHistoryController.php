<?php

namespace App\Http\Controllers;

use App\Models\CallHistory;
use Illuminate\Http\Request;
use Carbon\Carbon; // Import Carbon class


class CallHistoryController extends Controller
{
    //

    // show employees method 
    public function showCallHistory()
    {
        $CallHistory = CallHistory::orderBy('id', 'desc')->get();
        return view('allCalls')->with('CallHistory', $CallHistory);

        //    return blade
    }

    // public function callHistoryByEmployee(Request $request)
    // {
    //     $CallHistory = CallHistory::where('employee_id', $request->employee_id)->orderBy('id', 'desc')->get();
    //     // return view('callsByEmployee')->with('CallHistoryByEmployee', $CallHistoryByEmployee);
    //     return view('callsByEmployee')->with('CallHistoryByEmployee', $CallHistoryByEmployee);
    // }

    public function callHistoryByEmployee(Request $request)
{
    $CallHistoryByEmployee = CallHistory::where('employee_id', $request->employee_id)->orderBy('id', 'desc')->get();
    return view('callsByEmployee')->with('CallHistoryByEmployee', $CallHistoryByEmployee);
}



    public function callHistoryDetail(Request $request)
    {
        $calls = CallHistory::findOrFail($request->call_id);

        return view('callHistoryDetails')->with('calls', $calls);
    }


    public function todayCallHistory()
    {
        $today = Carbon::today();
        $callHistories = CallHistory::with('employee')->whereDate('created_at', $today)->orderBy('id', 'desc')->get();
        return view('todayCalls', compact('callHistories'));
    }



    public function todaycallhistoryDetail(Request $request)
    {
        $calls = CallHistory::findOrFail($request->call_id);

        return view('todayCallsDetails')->with('calls', $calls);
    }


    public function filterCallHistory(Request $request)
    {
        $query = CallHistory::with('employee');

        

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->input('to_date'));
        }

        $callHistories = $query->orderBy('id', 'desc')->get();

        return view('todayCalls', compact('callHistories'));
    }











}