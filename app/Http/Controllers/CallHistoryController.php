<?php

namespace App\Http\Controllers;
use App\Models\CallHistory;
use Illuminate\Http\Request;

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

public function callHistoryByEmployee(Request $request)
{
    $CallHistory = CallHistory::where('employee_id' , $request->employee_id)->orderBy('id', 'desc');
    // return view('callsByEmployee')->with('CallHistoryByEmployee', $CallHistoryByEmployee);
    return view('callsByEmployee')->with('CallHistoryByEmployee', $CallHistoryByEmployee);
}


public function callHistoryDetail(Request $request)
{
    $calls = CallHistory::findOrFail($request->call_id);
   
    return view('callHistoryDetails')->with('calls', $calls);
}











 }