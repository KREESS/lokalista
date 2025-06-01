<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SuperAdminUserController extends Controller
{
    public function index()
    {
        $users = User::whereIn('type', ['admin', 'customer'])->get();
        return view('super_admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('super_admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'type' => 'admin',
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('superadmin.users.index')->with('success', 'Admin berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('super_admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => "required|unique:users,email,$id",
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('superadmin.users.index')->with('success', 'Data admin diperbarui.');
    }

    public function destroy($id)
    {
        User::where('id', $id)->where('type', 'admin')->delete();
        return redirect()->route('superadmin.users.index')->with('success', 'Admin dihapus.');
    }

    public function toggleActive($id)
    {
        $user = User::where('id', $id)->where('type', 'customer')->firstOrFail();
        $user->is_active = !$user->is_active;
        $user->save();

        return back()->with('success', 'Status akun diperbarui.');
    }
}
