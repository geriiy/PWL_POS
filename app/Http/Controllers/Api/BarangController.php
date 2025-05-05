<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangModel;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index()
    {
        return BarangModel::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_kode' => 'required|unique:m_barang',
            'barang_nama' => 'required',
            'kategori_id' => 'required|exists:m_kategori,kategori_id',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        // handle upload gambar
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('barang', 'public');
            $data['barang_gambar'] = $path;
        }

        $barang = BarangModel::create($data);

        return response()->json($barang, 201);
    }

    public function show($id)
    {
        return BarangModel::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $barang = BarangModel::findOrFail($id);

        $data = $request->all();

        // update file jika ada file baru
        if ($request->hasFile('image')) {
            if ($barang->barang_gambar && Storage::disk('public')->exists($barang->barang_gambar)) {
                Storage::disk('public')->delete($barang->barang_gambar);
            }

            $file = $request->file('image');
            $path = $file->store('barang', 'public');
            $data['barang_gambar'] = $path;
        }

        $barang->update($data);

        return response()->json($barang);
    }

    public function destroy($id)
    {
        $barang = BarangModel::findOrFail($id);

        if ($barang->barang_gambar && Storage::disk('public')->exists($barang->barang_gambar)) {
            Storage::disk('public')->delete($barang->barang_gambar);
        }

        $barang->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
