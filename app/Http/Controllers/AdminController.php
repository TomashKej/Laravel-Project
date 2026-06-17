<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

/**
 * Handles admin user management actions.
 *
 * This controller allows an administrator to view, search, create, edit,
 * activate, deactivate and manage administrator roles for user accounts.
 */
class AdminController extends Controller
{
    /**
     * Ensures that the current user is logged in and has administrator privileges.
     *
     * If the user is not authenticated or is not an admin, the request is stopped
     * with a 403 Forbidden response.
     */
    private function ensureAdmin(): void
    {
        if (!Auth::check() || !Auth::user()->IsAdmin) {
            abort(403);
        }
    }

    /**
     * Displays a list of users in the admin panel.
     *
     * The method allows searching users by name or email address
     * and returns the results ordered by user name.
     */
    public function Users(Request $request)
    {
        $this->ensureAdmin();

        $search = $request->query('search');

        $query = User::query();

        if ($search != null && $search != '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
                    
                    if ($search == 'active') {
                        $q->orWhere('IsActive', true);
                    }

                    if ($search == 'inactive') {
                        $q->orWhere('IsActive', false);
                    }
            });
        }

        $users = $query->orderBy('name')->get();

        return view('admin.users.index', [
            'models' => $users,
            'search' => $search,
        ]);
    }

    /**
     * Displays the form used to create a new user account.
     */
    public function Create()
    {
        $this->ensureAdmin();

        return view('admin.users.create');
    }

    /**
     * Validates and stores a new user account.
     *
     * The method creates a new user, hashes the password and security answer,
     * sets account permissions and saves the user in the database.
     */
    public function Store(Request $request)
    {
        $this->ensureAdmin();

        $request->validate([
            'name' => [
                'required',
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
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
            'SecurityQuestion' => [
                'required',
                'max:255',
            ],
            'SecurityAnswer' => [
                'required',
                'max:255',
            ],
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->IsAdmin = $request->has('IsAdmin');
        $user->IsActive = $request->has('IsActive');
        $user->SecurityQuestion = $request->input('SecurityQuestion');
        $user->SecurityAnswerHash = strtolower(trim($request->input('SecurityAnswer')));
        $user->save();

        return redirect('/admin/users')->with('success', 'User has been created successfully.');
    }

    /**
     * Displays the edit form for an existing user.
     *
     * The user is loaded by ID or a 404 error is returned if the user does not exist.
     */
    public function Edit(int $id)
    {
        $this->ensureAdmin();

        $user = User::findOrFail($id);

        return view('admin.users.edit', [
            'model' => $user,
        ]);
    }

    /**
     * Validates and updates an existing user account.
     *
     * The method updates user details, permissions and security question.
     * Password and security answer are updated only when new values are provided.
     */
    public function Update(Request $request, int $id)
    {
        $this->ensureAdmin();

        $user = User::findOrFail($id);

        $request->validate([
            'name' => [
                'required',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($id, 'id'),
            ],
            'password' => [
                'nullable',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
            'SecurityQuestion' => [
                'required',
                'max:255',
            ],
            'SecurityAnswer' => [
                'nullable',
                'max:255',
            ],
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->input('password') != null && $request->input('password') != '') {
            $user->password = $request->input('password');
        }

        if (Auth::id() == $user->id) {
            $user->IsAdmin = true;
            $user->IsActive = true;
        } else {
            $user->IsAdmin = $request->has('IsAdmin');
            $user->IsActive = $request->has('IsActive');
        }
        $user->SecurityQuestion = $request->input('SecurityQuestion');

        if ($request->input('SecurityAnswer') != null && $request->input('SecurityAnswer') != '') {
            $user->SecurityAnswerHash = strtolower(trim($request->input('SecurityAnswer')));
        }

        $user->save();

        return redirect('/admin/users')->with('success', 'User has been updated successfully.');
    }

    /**
     * Activates a user account.
     *
     * The method sets the IsActive flag to true, allowing the user account
     * to be treated as active in the system.
     */
    public function Activate(int $id)
    {
        $this->ensureAdmin();

        $user = User::findOrFail($id);
        $user->IsActive = true;
        $user->save();

        return redirect('/admin/users')->with('success', 'User has been activated successfully.');
    }

    /**
     * Deactivates a user account.
     *
     * The method prevents the currently logged-in administrator from deactivating
     * their own account, then sets the selected user's IsActive flag to false.
     */
    public function Deactivate(int $id)
    {
        $this->ensureAdmin();

        if (Auth::id() == $id) {
            return redirect('/admin/users')->with('error', 'You cannot deactivate your own account.');
        }

        $user = User::findOrFail($id);
        $user->IsActive = false;
        $user->save();

        return redirect('/admin/users')->with('success', 'User has been deactivated successfully.');
    }

    /**
     * Promotes a user to administrator.
     *
     * The method sets the selected user's IsAdmin flag to true.
     */
    public function MakeAdmin(int $id)
    {
        $this->ensureAdmin();

        $user = User::findOrFail($id);
        $user->IsAdmin = true;
        $user->save();

        return redirect('/admin/users')->with('success', 'User has been promoted to admin successfully.');
    }

    /**
     * Removes administrator privileges from a user.
     *
     * The method prevents the currently logged-in administrator from removing
     * their own admin role, then sets the selected user's IsAdmin flag to false.
     */
    public function RemoveAdmin(int $id)
    {
        $this->ensureAdmin();

        if (Auth::id() == $id) {
            return redirect('/admin/users')->with('error', 'You cannot remove your own admin role.');
        }

        $user = User::findOrFail($id);
        $user->IsAdmin = false;
        $user->save();

        return redirect('/admin/users')->with('success', 'Admin role has been removed successfully.');
    }
}