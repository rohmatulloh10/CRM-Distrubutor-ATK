<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Models\MnUser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Helpers\LogActivity;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = MnUser::getAllUsers();
            return response()->json(['data' => $users]);
        }

        return view('pengguna.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,sales'
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role
        ]);

        LogActivity::add('create', 'users', $user->id, 'Menambahkan user baru: ' . $user->name);

        return response()->json(['success' => true, 'message' => 'User berhasil ditambahkan!']);
    }

    public function show($id)
    {
        return response()->json(User::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->only('name', 'email', 'role');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        LogActivity::add('update', 'users', $user->id, 'Mengubah data user: ' . $user->name);

        return response()->json(['message' => 'User berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $nama = $user->name;
        $user->delete();

        LogActivity::add('delete', 'users', $id, 'Menghapus user: ' . $nama);

        return response()->json(['success' => true, 'message' => 'User berhasil dihapus']);
    }
}

