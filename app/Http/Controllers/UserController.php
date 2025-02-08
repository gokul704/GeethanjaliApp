<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Students;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

use function Laravel\Prompts\alert;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,superadmin']);
    }

    /**
     * Display the list of users.
     */
    public function index()
    {
        $users = User::all();
        return view('user-management.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('user-management.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all()); // This will show all submitted form data in the browser

        DB::beginTransaction();

        try {
            // Validate User
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'role' => ['required', Rule::in(['student', 'faculty'])],
            ]);

            // Create User
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
            ]);

            // Handle Student Role
            if ($user->role == 'student') {
                $studentData = $request->validate([
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'roll_no' => 'required|string|unique:students,roll_no',
                    'stream' => 'required|string',
                    'joining_year' => 'required|string',
                ]);

                Students::create([
                    'user_id' => $user->id,
                    'first_name' => $studentData['first_name'],
                    'last_name' => $studentData['last_name'],
                    'roll_no' => $studentData['roll_no'],
                    'college_mail_id' => $user->email,
                    'stream' => $studentData['stream'],
                    'joining_year' => $studentData['joining_year'],
                    'is_alumuni' => $request->has('is_alumuni'),
                ]);
            }

            // Handle Faculty Role
            if ($user->role == 'faculty') {
                $facultyData = $request->validate([
                    'faculty_id' => 'required|string|unique:faculties,faculty_id',
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'mobile' => 'required|string|max:15|unique:faculties,mobile',
                    'stream' => 'required|string',
                    'faculty_role' => 'required|in:faculty,hod,dean,principal,admin,superadmin',
                ]);

                Faculty::create([
                    'user_id' => $user->id,
                    'faculty_id' => $facultyData['faculty_id'],
                    'first_name' => $facultyData['first_name'],
                    'last_name' => $facultyData['last_name'],
                    'mobile' => $facultyData['mobile'],
                    'email' => $user->email,
                    'stream' => $facultyData['stream'],
                    'designation' => $facultyData['faculty_role'],
                ]);
            }

            DB::commit();
            return redirect()->route('users.index')->with('success', 'User created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('users.index')->with('error', 'Error: ' . $e->getMessage());
        }

    }


    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('user-management.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in(['student', 'faculty'])],
        ]);

        // Update User
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ]);

        if ($user->role == 'student') {
            $studentData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'roll_no' => 'required|string|unique:students,roll_no,' . $user->id . ',user_id',
                'stream' => 'required|string',
                'joining_year' => 'required|string',
            ]);

            $studentData['is_alumuni'] = $request->has('is_alumuni');

            $user->student()->updateOrCreate(['user_id' => $user->id], $studentData);
        }

        if ($user->role == 'faculty') {
            $facultyRole = $request->validate([
                'faculty_role' => 'required|in:admin,superadmin',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'mobile' => 'required|string|max:15',
                'stream' => 'required|string',
            ]);

            $facultyData = [
                'first_name' => $facultyRole['first_name'],
                'last_name' => $facultyRole['last_name'],
                'mobile' => $facultyRole['mobile'],
                'stream' => $facultyRole['stream'],
                'designation' => $facultyRole['faculty_role'], // Admin or Superadmin
            ];

            $user->faculty()->updateOrCreate(['user_id' => $user->id], $facultyData);

            // Update User Role to Selected Faculty Role
            $user->update(['role' => $facultyRole['faculty_role']]);
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        if ($user->role === 'student') {
            $user->student()->delete();
        }

        if ($user->role === 'faculty') {
            $user->faculty()->delete();
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
