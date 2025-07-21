<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use App\Exports\UsersExportCustom;
use Maatwebsite\Excel\Facades\Excel; 

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('profile');
        
        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        
        $users = $query->latest()->paginate(15);
        
         // Hitung total user per role
        $userRoles = User::select('role')
        ->selectRaw('count(*) as total')
        ->groupBy('role')
        ->pluck('total', 'role');

        return view('admin.users.index', compact('users', 'userRoles'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,hrd,applicant'],
            'phone_number' => ['nullable', 'string', 'max:15'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone_number' => $request->phone_number,
            'email_verified_at' => now(), // Auto-verify admin-created accounts
        ]);
        
        // Create user profile
        $user->profile()->create();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        $user->load('profile', 'applications.jobVacancy');
        
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:admin,hrd,applicant'],
            'phone_number' => ['nullable', 'string', 'max:15'],
        ]);
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone_number' => $request->phone_number,
        ]);
        
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
            
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }
        
        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User updated successfully.');
    }

    public function export(Request $request)
{
    $query = User::with('profile');

    // Filter by role
    if ($request->filled('role')) {
        $query->where('role', $request->role);
    }

    // Filter by status (active / inactive)
    if ($request->filled('status')) {
        if ($request->status == 'active') {
            $query->whereNotNull('email_verified_at');
        } elseif ($request->status == 'inactive') {
            $query->whereNull('email_verified_at');
        }
    }

    // Search by name or email
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('email', 'like', '%' . $search . '%');
        });
    }

    $users = $query->get();

    return Excel::download(new UsersExportCustom($users), 'users.xlsx');
}
    public function destroy(User $user)
    {
        // Prevent deleting self
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function toggleStatus(User $user)
    {
        // Prevent toggling self
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own status.');
        }
        
        DB::beginTransaction();
        try {
            if ($user->email_verified_at) {
                $user->email_verified_at = null;
                $user->save();
                $status = 'deactivated';
            } else {
                $user->email_verified_at = now();
                $user->save();
                $status = 'activated';
            }
            DB::commit();
            
            return redirect()->route('admin.users.index')
                ->with('success', "User {$status} successfully.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update user status: ' . $e->getMessage());
        }
    }
}