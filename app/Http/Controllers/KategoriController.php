<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    public function index()
    {
        return view('kategori.index');
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_nama' => 'required|string|max:100|unique:m_kategori,kategori_nama',
        ]);

        KategoriModel::create($request->all());

        return redirect('/kategori')->with('success', 'Data kategori berhasil disimpan');
    }

    public function show(KategoriModel $kategori)
    {
        return view('kategori.show', compact('kategori'));
    }

    public function edit(KategoriModel $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, KategoriModel $kategori)
    {
        $request->validate([
            'kategori_nama' => 'required|string|max:100|unique:m_kategori,kategori_nama,'.$kategori->kategori_id,
        ]);

        $kategori->update($request->all());

        return redirect('/kategori')->with('success', 'Data kategori berhasil diperbarui');
    }

    public function destroy(KategoriModel $kategori)
    {
        try {
            $kategori->delete();
            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/kategori')->with('error', 'Data kategori gagal dihapus karena masih terdapat tabel lain yang terkait');
        }
    }
}
