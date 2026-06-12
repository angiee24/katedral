<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    
    public function index()
    {
        if (!Auth::user()->hasPermission('manage-users')) {
            abort(403);
        }

        $users = User::with('roles')->paginate(10);
        $roles = Role::all();

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    
    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('manage-users')) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $role = Role::findById($validated['role_id']);
        $user->assignRole($role);

        ActivityLogService::log("Membuat user baru: {$user->name} ({$user->email})");

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    
    public function update(Request $request, User $user)
    {
        if (!Auth::user()->hasPermission('manage-users')) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
        ]);

        $newRole = Role::findById($validated['role_id']);

        
        if ($user->id === Auth::id() && !$user->hasRole($newRole->name)) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat mengubah peran Anda sendiri.');
        }

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $user->syncRoles([$newRole->name]);

        ActivityLogService::log("Memperbarui user: {$user->name}");

        return redirect()->route('admin.users.index')->with('success', 'Informasi user berhasil diperbarui.');
    }

    
    public function resetPassword(Request $request, User $user)
    {
        if (!Auth::user()->hasPermission('manage-users')) {
            abort(403);
        }

        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        ActivityLogService::log("Mereset kata sandi untuk user: {$user->name}");

        return redirect()->route('admin.users.index')->with('success', 'Kata sandi user berhasil direset.');
    }

    
    public function destroy(User $user)
    {
        if (!Auth::user()->hasPermission('manage-users')) {
            abort(403);
        }

        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $name = $user->name;
        $user->delete();

        ActivityLogService::log("Menghapus user: {$name}");

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
