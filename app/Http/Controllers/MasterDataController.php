<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InterestedIn;


class MasterDataController extends Controller
{
    //


    // public function interested()
    // {
    //     // Fetch and sort the data by 'type' column
    //     $interestedIn = InterestedIn::orderBy('type', 'asc')->get();  // You can change 'asc' to 'desc' for descending order

    //     // Return the view with the sorted data
    //     return view('InterestedIn', compact('interestedIn'));
    // }

    // // Function to handle form submission
    // public function interestedIn(Request $request)
    // {
    //     // Validate the input
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //     ]);

    //     // Create a new record in the 'interested_in' table
    //     InterestedIn::create([
    //         'type' => $request->name,
    //     ]);

    //     // Redirect back to the form and refresh the data
    //     return redirect()->route('interested_in')->with('success', 'Record added successfully!');
    // }



    // public function interested()
    // {
    //     // Fetch all records from the 'interested_in' table
    //     $interestedIn = InterestedIn::orderBy('type', 'asc')->get();

    //     // Return the view with the fetched data
    //     return view('interestedIn', compact('interestedIn'));
    // }

    // // Handle form submission and store data
    // public function interestedIn(Request $request)
    // {
    //     // Validate the input
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //     ]);

    //     // Create a new record in the 'interested_in' table
    //     InterestedIn::create([
    //         'type' => $request->name,
    //     ]);

    //     // Redirect back with a success message
    //     return redirect()->route('interested_in')->with('success', 'Record added successfully!');
    // }


    // public function interestedIn(Request $request)
    // {
    //     if ($request->isMethod('post')) {
    //         // Validate the input
    //         $request->validate([
    //             'name' => 'required|string|max:255',
    //         ]);
    
    //         // Create a new record in the 'interested_in' table
    //         InterestedIn::create([
    //             'interested_type' => $request->name,
    //         ]);
    
    //         // Redirect back with a success message
    //         return redirect()->route('interested_in')->with('success', 'Record added successfully!');
    //     }
    
    //     // Fetch all records from the 'interested_in' table for GET request
    //     $interestedIn = InterestedIn::orderBy('interested_type', 'asc')->get();
    
    //     // Return the view with the fetched data
    //     return view('InterestedIn', compact('interestedIn'));
    // }
    


    public function interestedIn(Request $request)
{
    if ($request->isMethod('post')) {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create a new record in the 'interested_in' table
        InterestedIn::create([
            'interested_type' => $request->name,  // Ensure 'name' field corresponds to form input
        ]);

        // Redirect back with a success message
        return redirect()->route('interested_in')->with('success', 'Record added successfully!');
    }

    // Fetch all records from the 'interested_in' table for GET request
    $interestedIn = InterestedIn::orderBy('interested_type', 'asc')->get();

    // Return the view with the fetched data
    return view('InterestedIn', compact('interestedIn'));
}

}
