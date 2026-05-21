<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function create()
    {
        return view('login.index');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'  => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'user_id.required'  => 'Please enter your User ID.',
            'password.required' => 'Please enter your password.',
        ]);

        $userId   = $request->input('user_id');
        $password = $request->input('password');

        // Step 1: Find user by user_id
        $user = \App\Models\User::where('user_id', $userId)->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'user_id' => 'Invalid User ID. No account found with that ID.',
            ]);
        }

        // Step 2: Check password manually
        if (! \Illuminate\Support\Facades\Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => 'Incorrect password. Please try again.',
            ]);
        }

        // Step 3: Log the user in manually
        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard.index'));
    }

    /**
     * Destroy an authenticated session (logout).
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}