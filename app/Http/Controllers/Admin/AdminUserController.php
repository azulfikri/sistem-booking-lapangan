<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * Display a listing of admin users
     */
    public function index()
    {
        // Hanya tampilkan user dengan role 'admin'
        $users = User::where('role', 'admin')
            ->latest()
            ->paginate(10);
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new admin
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created admin in database
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        // Hash password
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()
            ->route('admin.users')
            ->with('success', 'Admin berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified admin
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified admin in database
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validated();

        // Hash password hanya jika diisi
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('admin.users')
            ->with('success', 'Admin berhasil diupdate!');
    }

    /**
     * Remove the specified admin from database
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Cegah admin menghapus dirinya sendiri
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('admin.users')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $user->delete();

        return redirect()
            ->route('admin.users')
            ->with('success', 'Admin berhasil dihapus!');
    }
}
