<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return UserModel::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:m_user,username|max:50',
            'password' => 'required|string|min:6',
            'nama' => 'required|string|max:100',
            'level_id' => 'required|exists:m_level,level_id'
        ]);

        $user = UserModel::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nama' => $request->nama,
            'level_id' => $request->level_id
        ]);

        return response()->json($user, 201);
    }

    public function show($id)
    {
        return UserModel::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $user = UserModel::findOrFail($id);

        $request->validate([
            'username' => 'sometimes|unique:m_user,username,' . $id . ',user_id|max:50',
            'password' => 'nullable|string|min:6',
            'nama' => 'sometimes|string|max:100',
            'level_id' => 'sometimes|exists:m_level,level_id'
        ]);

        $data = $request->only(['username', 'nama', 'level_id']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = UserModel::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User berhasil dihapus.']);
    }
}
