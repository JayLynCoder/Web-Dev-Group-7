<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (session()->has('user_id')) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! password_verify($credentials['password'], $user->password_hash)) {
            return back()
                ->withErrors(['email' => 'Invalid credentials.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        session([
            'user_id' => $user->id,
            'is_admin' => (bool) $user->is_admin,
            'full_name' => $user->full_name,
        ]);

        return redirect()->route('dashboard');
    }

    /** /dashboard sends each role to its own home page. */
    public function home(): RedirectResponse
    {
        return redirect()->route(session('is_admin') ? 'admin.dashboard' : 'employee.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => 'required|string|max:50|alpha_dash|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
        ]);

        User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'full_name' => $validated['username'],
            'password_hash' => password_hash($validated['password'], PASSWORD_BCRYPT),
            'is_admin' => false,
        ]);

        return redirect()->route('register')->with('registration_success', true);
    }
}
