<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Get users with pagination
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        // Don't allow an admin to demote themselves
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat mengubah role Anda sendiri.');
        }

        $request->validate([
            'role' => 'required|in:user,admin',
        ]);

        $user->update(['role' => $request->role]);

        return back()->with('success', 'Role pengguna ' . $user->name . ' berhasil diperbarui menjadi ' . ucfirst($request->role) . '.');
    }
}
