<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'staff') {
            $users = User::where('role', 'staff')->get();
        } else {
            $users = User::all();
        }

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $auth = auth()->user();

        if ($auth->role === 'staff') {
            return view('users.create', ['role_locked' => 'staff']);
        }

        return view('users.create');
    }

    public function store(Request $request)
    {
        $auth = auth()->user();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,staff'
        ]);

        if ($auth->role === 'staff') {
            $request->merge(['role' => 'staff']);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dibuat');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $auth = auth()->user();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,staff'
        ]);

        if ($auth->role === 'staff') {
            $request->merge(['role' => 'staff']);
        }

        $user->update($request->only('name', 'email', 'role'));

        return redirect()->route('users.index')
            ->with('success', 'User berhasil diupdate');
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|min:6'
        ]);

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password berhasil diubah');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'User berhasil dihapus');
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
