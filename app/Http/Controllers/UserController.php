<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('edit-user', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:100|unique:users,username,' . $id,
            'email'    => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->username = $request->username;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password_hash = password_hash($request->password, PASSWORD_DEFAULT);
        }

        if (session('role') === 'super_admin' && $request->has('is_admin')) {
            $user->role = $request->is_admin ? 'admin' : 'user';
            $user->is_admin = $request->is_admin ? 1 : 0;
        }

        $user->save();

        return redirect()->route('users.index')->with('status', 'User updated successfully.');
    }

    public function destroy($user)
    {
        $userModel = User::findOrFail($user);

        if ($userModel->role === 'super_admin' || ($userModel->role === 'admin' && session('role') !== 'super_admin')) {
            return back()->withErrors(['error' => 'You do not have permission to delete this account.']);
        }

        $userModel->delete();
        return redirect()->route('users.index')->with('status', 'Account deleted successfully.');
    }
}