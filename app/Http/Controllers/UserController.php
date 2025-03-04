<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
      
        $user = UserModel::all();

        return view('user', ['data' => $user]);
    }
    public function tambah()
    {
        return view('user_tambah');
    }

    public function tambah_simpan(Request $request)
{
    // Validasi input
    $request->validate([
        'username' => 'required|string|max:255|unique:m_user,username',
        'nama' => 'required|string|max:255',
        'password' => 'required|string|min:6',
        'level_id' => 'required|integer'
    ]);

    // Simpan data ke database
    UserModel::create([
        'username' => $request->username,
        'nama' => $request->nama,
        'password' => Hash::make($request->password), // Hash password
        'level_id' => $request->level_id
    ]);

    return redirect('/user')->with('success', 'User berhasil ditambahkan!');
}


    public function ubah($id)
    {
        $user = UserModel::find($id);
        if (!$user) {
            return redirect('/user')->with('error', 'User tidak ditemukan!');
        }
        return view('user_ubah', ['data' => $user]);
    }


    public function ubah_simpan($id, Request $request)
    {
        $user = UserModel::find($id);

        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = Hash::make($request->password);
        $user->level_id = $request->level_id;

        $user->save();

        return redirect('/user');
    }

    public function hapus($id)
    {
        $user = UserModel::find($id);
        $user->delete();
        return redirect('/user');
    }
}
