<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;


class MessageController extends Controller
{
    public function addMessage(Request $request)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'category' => 'required|string|max:255',

        ]);

        $admin_id = auth()->id();


        // Create a new message
        $message = new Message();
        $message->title = $request->input('title');
        $message->message = $request->input('message');
        $message->category = $request->input('category');
        $message->admin_id = $admin_id;  // Store the admin ID in the message


        $message->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Message added successfully!');
    }

   
    public function showMessage()
    {
        // Get the authenticated admin's ID using the 'admin' guard
        $admin_id = auth()->id();
    
        // Fetch all messages that belong to the authenticated admin
        $messages = Message::where('admin_id', $admin_id)->get();
    
        // Return the view with messages
        return view('showMessage', compact('messages'));
    }
    

    public function messageDetail($id)
    {
        // Fetch the message by its ID or throw a 404 error if not found
        $message = Message::findOrFail($id);
    
        // Return the view with the message
        return view('messageDetails', compact('message')); 
    }

public function editMessage($id)
{
    $message = Message::findOrFail($id);
    return view('updateMessage', compact('message'));
}


public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'message' => 'required|string|max:255',
        'category' => 'required|string|max:20',
    ]);

    $msg = Message::findOrFail($id);
    $msg->title = $validatedData['title'];
    $msg->message = $validatedData['message'];
    $msg->category = $validatedData['category'];

    $msg->save();
    $request->session()->flash('success', 'message update successfully.');
    return redirect()->route('show_message')->with('success', 'message updated successfully.');
}


    public function destroyMessage($id)
{
    $message = Message::findOrFail($id);
    $message->delete();

    return redirect()->route('show_message')->with('success', 'message deleted successfully');
}


}
