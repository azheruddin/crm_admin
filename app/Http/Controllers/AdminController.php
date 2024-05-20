<?php

namespace App\Http\Controllers;
use App\Models\Admin;


use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function login(Request $request)
{
    $validatedData = $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    // Find the admin by email
    $admin = Admin::where('email', $validatedData['email'])->first();

    // Check if the admin exists
    if (!$admin) {
        return response()->json([
            'message' => 'Admin not found',
        ], 404);
    }

    // Compare the provided password with the one stored in the database
    if ($validatedData['password'] === $admin->password) {
        // Password is correct, proceed with login logic
        // For example, generate token or session here
        return response()->json([
            'message' => 'Login successful',
            'admin' => $admin,
        ]);
    } else {
        // Password is incorrect
        return response()->json([
            'message' => 'Invalid password',
        ], 401);
    }
}
}
