<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Public page
    public function index()
    {
        return view('public.contact');
    }

    // Submit form
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        ContactMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Thank you for your message! Our team will get back to you shortly.');
    }

    // Admin index
    public function adminIndex()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.contact.index', compact('messages'));
    }

    // Admin show message
    public function show(ContactMessage $message)
    {
        $message->update(['is_read' => true]);
        return view('admin.contact.show', compact('message'));
    }

    // Admin mark unread
    public function toggleRead(ContactMessage $message)
    {
        $message->update(['is_read' => !$message->is_read]);
        return back()->with('success', 'Message marked successfully.');
    }

    // Admin delete message
    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return redirect()->route('admin.contact.index')->with('success', 'Message deleted successfully.');
    }
}
