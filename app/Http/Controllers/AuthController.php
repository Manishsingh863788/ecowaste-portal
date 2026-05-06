<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ── Show Login Form ──────────────────────────────────────────
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    // ── Handle Login ─────────────────────────────────────────────
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))
                ->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'These credentials do not match our records.']);
    }

    // ── Show Register Form ───────────────────────────────────────
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    // ── Handle Register ──────────────────────────────────────────
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:100',
            'email'                 => 'required|email|unique:users,email|max:150',
            'password'              => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')
            ->with('success', 'Account created! Welcome to EcoWaste, ' . $user->name . '!');
    }

    // ── Logout ───────────────────────────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
    }

    // ── Dashboard ────────────────────────────────────────────────
    public function dashboard()
    {
        $user           = Auth::user();
        $totalRequests  = \App\Models\WasteRequest::count();
        $pendingCount   = \App\Models\WasteRequest::where('status', 'pending')->count();
        $completedCount = \App\Models\WasteRequest::where('status', 'completed')->count();
        $urgentCount    = \App\Models\WasteRequest::where('is_urgent', true)
                            ->whereNotIn('status', ['completed', 'cancelled'])->count();
        $recentRequests = \App\Models\WasteRequest::latest()->take(5)->get();

        return view('auth.dashboard', compact(
            'user',
            'totalRequests',
            'pendingCount',
            'completedCount',
            'urgentCount',
            'recentRequests'
        ));
    }
}
