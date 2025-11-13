<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLogin()
    {
        // If already logged in, redirect based on role
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        // Validate the request
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:5',
        ]);

        // Attempt to find the user
        $account = Account::where('email', $credentials['email'])->first();

        // Check if user exists and password is correct
        if (!$account || !Hash::check($credentials['password'], $account->password)) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        // Log the user in
        Auth::login($account, $request->boolean('remember'));

        // Regenerate session to prevent fixation attacks
        $request->session()->regenerate();

        // Redirect based on role
        return $this->redirectBasedOnRole($account)
            ->with('success', 'Welcome back!');
    }

    /**
     * Show the registration form
     */
    public function showRegister()
    {
        // If already logged in, redirect
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        
        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:accounts,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        // Create new user account (default role is 'user')
        $account = Account::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Default role
        ]);

        // Redirect to login instead of homepage
        return redirect()->route('login')
            ->with('success', 'Registration successful! Please log in.');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
    }

    /**
     * Redirect user based on their role
     */
    private function redirectBasedOnRole($account)
    {
        if ($account->role === 'admin') {
            return redirect()->route('admin.homepage');
        }
        
        // Default to client homepage
        return redirect()->route('client.homepage.index');
    }
}