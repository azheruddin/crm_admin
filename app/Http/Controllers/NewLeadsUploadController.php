<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LeadsImport;

use Illuminate\Http\Request;

class NewLeadsUploadController extends Controller
{
    //

    // public function __construct()
    // {
    //     $this->middleware('auth:web');
    // }

    public function index()
    {
        // $menu="imports";
        return view('NewLeadsUpload');
    }
    public function create(Request $request){
        
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
            'employee_id' => 'required|exists:employees,id', // Ensure employee ID is valid
        ]);

        $employeeId = $request->input('employee_id');
        $admin_id = auth()->id();
        try {
            // Excel::import(new LeadsImport, $request->file('file'));
            Excel::import(new LeadsImport($employeeId, $admin_id), $request->file('file'));
            return redirect()->back()->with('success', 'Import successful!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
