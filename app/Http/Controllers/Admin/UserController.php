<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of admin users.
     */
    public function index()
    {
        // Fetch all users except the current user
        $users = User::where('id', '!=', auth()->id())->orderBy('role', 'desc')->get();
        return view('admin.super.users', compact('users'));
    }

    /**
     * Store a newly created admin.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'nullable|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,super_admin',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        ActivityLog::log('Tambah Pengguna', "Membuat akun baru: '{$user->username}' dengan role '{$user->role}'");

        return back()->with('success', 'Akun admin berhasil dibuat!');
    }

    /**
     * Update the specified admin.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => "required|string|max:255|unique:users,username,{$id}",
            'email' => "nullable|email|max:255|unique:users,email,{$id}",
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,super_admin',
        ]);

        $userData = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $userData['password'] = bcrypt($request->password);
        }

        $user->update($userData);

        ActivityLog::log('Edit Pengguna', "Mengubah akun admin: '{$user->username}'");

        return back()->with('success', 'Akun admin berhasil diperbarui!');
    }

    /**
     * Remove the specified admin.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting oneself
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $username = $user->username;
        $user->delete();

        ActivityLog::log('Hapus Pengguna', "Menghapus akun: '{$username}'");

        return back()->with('success', 'Akun admin berhasil dihapus!');
    }
}
