<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\StaffCreatedMail;

class StaffController extends Controller
{
    public function index()
    {
        $staffMembers = User::whereIn('role', ['admin', 'staff'])->orderBy('role')->orderBy('name')->get();
        return view('admin.staff.index', compact('staffMembers'));
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string|in:admin,staff',
        ]);

        $otp = Str::random(12);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($otp),
        ]);

        Mail::to($user->email)->send(new StaffCreatedMail($user, $otp));

        return redirect()->route('admin.staff.index')->with('success', 'Staff member added successfully. Credentials with a one-time password have been sent to their email.');
    }

    public function edit(User $staff)
    {
        // Fail if trying to edit a patient here
        if ($staff->role === 'patient') {
            abort(404);
        }
        return view('admin.staff.edit', compact('staff'));
    }

    public function update(Request $request, User $staff)
    {
        if ($staff->role === 'patient') {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $staff->id,
            'role' => 'required|string|in:admin,staff',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $staff->update($data);

        return redirect()->route('admin.staff.index')->with('success', 'Staff member details updated successfully.');
    }

    public function destroy(User $staff)
    {
        if ($staff->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot delete yourself.');
        }

        if ($staff->role === 'patient') {
            abort(404);
        }

        $staff->delete();
        return redirect()->route('admin.staff.index')->with('success', 'Staff member deleted successfully.');
    }
}
