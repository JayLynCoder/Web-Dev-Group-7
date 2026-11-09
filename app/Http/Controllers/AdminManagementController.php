<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminManagementController extends Controller
{
    public function index()
    {
        $admins = User::whereIn('role', ['admin', 'super_admin'])->get();
        return view('super-admin.admins', compact('admins'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:users,username',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $isAdmin = $request->has('is_admin') ? 1 : 0;

        User::create([
            'full_name'     => $validated['name'],
            'username'      => $validated['username'],
            'email'         => $validated['email'],
            'password_hash' => Hash::make($validated['password']),
            'role'          => $isAdmin ? 'admin' : 'user',
            'is_admin'      => $isAdmin,
        ]);

        return redirect()->route('admin.manage')->with('status', 'Admin account created successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('edit-user', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'username' => 'required|string|max:100|unique:users,username,' . $id,
            'email'    => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // When unchecked, has('is_admin') is false, correctly setting $isAdmin to 0
        $isAdmin = $request->has('is_admin') ? 1 : 0;

        if ($user->role === 'super_admin') {
            $isAdmin = 1; // Safeguard super admin role
        }

        $user->username = $validated['username'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password_hash = Hash::make($validated['password']);
        }

        $user->is_admin = $isAdmin;
        $user->role = $isAdmin ? ($user->role === 'super_admin' ? 'super_admin' : 'admin') : 'user';
        $user->save();

        return redirect()->route('users.index')->with('status', 'User account updated successfully.');
    }

    public function destroy($id)
    {
        $targetUser = User::findOrFail($id);

        if ($targetUser->role === 'super_admin' || $targetUser->id === session('user_id')) {
            return back()->withErrors(['error' => 'You cannot delete a Super Admin or your own account.']);
        }

        $targetUser->delete();

        return redirect()->route('admin.manage')->with('status', 'Admin removed successfully.');
    }
}