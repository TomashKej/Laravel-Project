<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

/**
 * Handles user authentication actions such as registration, login and logout.
 */
class AuthController extends Controller
{

    /**
     * Displays the registration form.
     */
    public function Register()
    {
        return view('auth.register');
    }

    /**
     * Validates registration data, creates a new user account,
     * hashes the password, logs the user in and redirects to service orders.
     */
    public function StoreRegister(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:2', 'max:255'],
            'email' => ['required', 'email', 'max:255','unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/[A-Z]/', 'regex:/[a-z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&]/'],
        ]);

            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->save();

            Auth::login($user);

            return redirect('/serviceOrders')->with('success', 'Account has been created successfully.');    }

    /**
     * Displays the login form.
     */
    public function Login()
    {
        return view('auth.login');
    }

    /**
     * Validates login data and attempts to authenticate the user.
     * If login is successful, the session is regenerated for security
     * and the user is redirected to the service orders page.
     */
    public function StoreLogin(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials)) 
        {
            $request->session()->regenerate();

        return redirect('/')->with('success', 'You have logged in successfully.');
        }

        return back()->with('error', 'Invalid Email or Password.')->onlyInput('email');
    }

    /**
     * Logs out the currently authenticated user, invalidates the session,
     * regenerates the CSRF token and redirects to the login page.
     */
    function Logout(Request $request)
    {
        Auth::Logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have logged out successfully.');    
    }
}
