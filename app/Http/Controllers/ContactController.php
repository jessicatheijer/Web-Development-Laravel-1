<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;  // Ensure Session facade is used

class ContactController extends Controller
{
    // Method to display contacts stored in session
    public function index()
    {
        $contact = session('contact', []);
        return view('contact', compact('contact'));
    }

    // Method to store a new contact into session
    public function store(Request $request)
    {
        $contact = session('contact', []);
        $contact[] = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message
        ];
        
        session(['contact' => $contact]);
        
        return redirect()->route('contact.index')->with('success', 'Message sent successfully');
    }

    // Optional: If you want to manage contacts via cookies instead of sessions
    public function storeInCookie(Request $request)
    {
        $contact = json_decode($request->cookie('contact', '[]'), true);
        $contact[] = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message
        ];

        $cookie = cookie('contact', json_encode($contact), 43200);  // 30 days
        
        return redirect()->route('contact.index')->cookie($cookie)->with('success', 'Message saved in cookie successfully');
    }

    // Remove the redundant or duplicate index method and other methods like ActionContact if not needed

    public function destroy($index)
{
    $contact = session('contact', []);
    if (isset($contact[$index])) {
        unset($contact[$index]); // Remove the contact at the specified index
        session(['contact' => $contact]); // Update the session
    }
    return redirect()->route('contact.index')->with('success', 'Contact deleted successfully');
}

}