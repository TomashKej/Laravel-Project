<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

/**
 * Handles user authentication actions.
 *
 * This controller is responsible for user registration, login, logout
 * and password recovery using a security question and answer.
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
     * Validates registration data and creates a new user account.
     *
     * The method validates the user's name, email and password,
     * creates a new user record, logs the user in automatically
     * and redirects them to the service orders page.
     */
    public function StoreRegister(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'min:2',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // The password is hashed before being saved in the database.
        $user->password = Hash::make($request->input('password'));

        $user->save();

        Auth::login($user);

        return redirect('/serviceOrders')->with('success', 'Account has been created successfully.');
    }

    /**
     * Displays the login form.
     */
    public function Login()
    {
        return view('auth.login');
    }

    /**
     * Validates login data and attempts to authenticate the user.
     *
     * Only active users are allowed to log in. If authentication is successful,
     * the session is regenerated for security and the user is redirected
     * to the home page.
     */
    public function StoreLogin(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
            ],
        ]);

        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'IsActive' => true,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect('/')->with('success', 'You have logged in successfully.');
        }

        return back()
            ->with('error', 'Invalid Email or Password.')
            ->onlyInput('email');
    }

    /**
     * Logs out the currently authenticated user.
     *
     * The method invalidates the current session, regenerates the CSRF token
     * and redirects the user back to the login page.
     */
    public function Logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have logged out successfully.');
    }

    /**
     * Displays the forgot password form.
     *
     * The form allows the user to enter their email address before
     * the configured security question is displayed.
     */
    public function ForgotPassword()
    {
        return view('auth.forgotPassword');
    }

    /**
     * Validates the submitted email address and checks password recovery configuration.
     *
     * The method searches for an active user by email address and checks
     * whether the user has a security question and answer configured.
     * If everything is correct, the user is redirected to the reset password form.
     */
    public function ForgotPasswordQuestion(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
            ],
        ]);

        $user = User::where('email', $request->input('email'))
            ->where('IsActive', true)
            ->first();

        if ($user == null) {
            return redirect('/forgotPassword')->with('error', 'Active user with this email address was not found.');
        }

        if ($user->SecurityQuestion == null || $user->SecurityAnswerHash == null) {
            return redirect('/forgotPassword')->with('error', 'This user does not have password recovery configured.');
        }

        return redirect('/forgotPassword/reset?email=' . urlencode($user->email));
    }

    /**
     * Validates the security answer and updates the user's password.
     *
     * The submitted security answer is normalised and compared with the stored hash.
     * If the answer is correct, the user's password is changed and the user
     * is redirected to the login page.
     */
    public function ResetPassword(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
            ],
            'SecurityAnswer' => [
                'required',
                'max:255',
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
        ]);

        $user = User::where('email', $request->input('email'))
            ->where('IsActive', true)
            ->first();

        if ($user == null) {
            return redirect('/forgotPassword')->with('error', 'Active user with this email address was not found.');
        }

        $securityAnswer = strtolower(trim($request->input('SecurityAnswer')));

        if (!Hash::check($securityAnswer, $user->SecurityAnswerHash)) {
            return redirect('/forgotPassword/reset?email=' . urlencode($user->email))
                ->withErrors(['SecurityAnswer' => 'Security answer is incorrect.'])
                ->withInput();
        }

        $user->password = $request->input('password');
        $user->save();

        return redirect('/login')->with('success', 'Password has been changed successfully. You can now log in.');
    }

    /**
     * Displays the reset password form with the user's security question.
     *
     * The method reads the email address from the query string, checks whether
     * an active user exists and passes the user's security question to the view.
     */
    public function ShowResetPassword(Request $request)
    {
        $email = $request->query('email');

        if ($email == null || $email == '') {
            return redirect('/forgotPassword')->with('error', 'Email address is required.');
        }

        $user = User::where('email', $email)
            ->where('IsActive', true)
            ->first();

        if ($user == null) {
            return redirect('/forgotPassword')->with('error', 'Active user with this email address was not found.');
        }

        if ($user->SecurityQuestion == null || $user->SecurityAnswerHash == null) {
            return redirect('/forgotPassword')->with('error', 'This user does not have password recovery configured.');
        }

        return view('auth.resetPassword', [
            'email' => $user->email,
            'securityQuestion' => $user->SecurityQuestion,
        ]);
    }
}