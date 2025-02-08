<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use App\Events\UserStatusChanged;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Users/Index', [
            'users' => User::with('roles')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(fn ($user) => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'roles' => $user->roles->pluck('name'),
                    'status' => $user->status,
                    'status_reason' => $user->status_reason,
                    'approved_at' => $user->approved_at ? $user->approved_at->format('d M Y H:i') : null,
                    'created_at' => $user->created_at->format('d M Y'),
                    'avatar' => $user->avatar,
                    'avatar_url' => $user->avatar ? asset('storage/' . $user->avatar) : null
                ])
        ]);
    }

    public function create()
    {
        return Inertia::render('Users/Create', [
            'roles' => Role::all()->map->only(['id', 'name']),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15',
            'password' => ['required', 'confirmed'],
            'roles' => 'required|array',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $user->syncRoles($request->roles);

        return redirect()->route('admin.users.index')
            ->with('message', 'User created successfully');
    }

    public function edit(User $user)
    {
        return Inertia::render('Users/Edit', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'roles' => $user->roles->pluck('id'),
            ],
            'roles' => Role::all()->map->only(['id', 'name']),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'phone' => 'required|string|max:15',
            'roles' => 'required|array',
        ];

        // Tambahkan validasi password hanya jika password diisi
        if ($request->filled('password')) {
            $rules['password'] = ['required', 'confirmed'];
        }

        $request->validate($rules);

        // Siapkan data update
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        // Tambahkan password ke data update jika diisi
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);
        $user->syncRoles($request->roles);

        return redirect()->route('admin.users.index')
            ->with('message', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('message', 'User deleted successfully');
    }

    public function approve(Request $request, User $user)
    {
        $oldStatus = $user->status;
        $user->approve($request->reason);
        
        event(new UserStatusChanged($user, $oldStatus, 'active'));

        return redirect()->route('admin.users.index')
            ->with('message', 'User approved successfully');
    }

    public function reject(Request $request, User $user)
    {
        $request->validate([
            'reason' => 'required|string|min:10'
        ], [
            'reason.required' => 'Alasan penolakan wajib diisi',
            'reason.min' => 'Alasan penolakan minimal 10 karakter'
        ]);

        $oldStatus = $user->status;
        $user->reject($request->reason);
        
        event(new UserStatusChanged($user, $oldStatus, 'rejected'));

        return redirect()->route('admin.users.index')
            ->with('message', 'User rejected successfully');
    }

    public function deactivate(Request $request, User $user)
    {
        $request->validate([
            'reason' => 'required|string|min:10'
        ], [
            'reason.required' => 'Alasan penonaktifan wajib diisi',
            'reason.min' => 'Alasan penonaktifan minimal 10 karakter'
        ]);

        $oldStatus = $user->status;
        $user->deactivate($request->reason);
        
        event(new UserStatusChanged($user, $oldStatus, 'inactive'));

        return redirect()->route('admin.users.index')
            ->with('message', 'User deactivated successfully');
    }

    public function ban(Request $request, User $user)
    {
        $request->validate([
            'reason' => 'required|string|min:10'
        ], [
            'reason.required' => 'Alasan banned wajib diisi',
            'reason.min' => 'Alasan banned minimal 10 karakter'
        ]);

        $oldStatus = $user->status;
        $user->ban($request->reason);
        
        event(new UserStatusChanged($user, $oldStatus, 'banned'));

        return redirect()->route('admin.users.index')
            ->with('message', 'User banned successfully');
    }
}