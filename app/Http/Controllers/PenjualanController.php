<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanModel;
use App\Models\PenjualanDetail;
use App\Models\BarangModel;

class PenjualanController extends Controller
{
    // Menampilkan daftar transaksi penjualan
    public function index()
    {
        $penjualan = PenjualanModel::all(); // Ini mengembalikan collection, bukan satu objek

        $penjualan = PenjualanModel::with('details.barang')->get();
        return view('penjualan.index', compact('penjualan', ), ['activeMenu' => 'penjualan']);
    }

    // Menampilkan form tambah transaksi
    public function create()
    {
        $barang = BarangModel::all();
        return view('penjualan.create', compact('barang'));
    }

    // Menyimpan transaksi baru
    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required',
            'jumlah' => 'required|integer|min:1'
        ]);

        // Simpan transaksi baru
        $penjualan = PenjualanModel::create([
            'tanggal' => now()
        ]);

        // Ambil data barang
        $barang = BarangModel::findOrFail($request->barang_id);

        // Simpan detail transaksi
        PenjualanDetail::create([
            'penjualan_id' => $penjualan->penjualan_id,
            'barang_id' => $barang->id,
            'harga' => $barang->harga,
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    // Menghapus transaksi
    public function destroy($id)
    {
        $penjualan = PenjualanModel::findOrFail($id);
        $penjualan->details()->delete();
        $penjualan->delete();

        return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil dihapus!');
    }

    public function edit($id)
{
    $penjualan = PenjualanModel::findOrFail($id);
    return view('penjualan.edit', compact('penjualan'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'barang_id' => 'required',
        'harga' => 'required|numeric',
        'jumlah' => 'required|integer',
    ]);

    $penjualan = PenjualanModel::findOrFail($id);
    $penjualan->update([
        'barang_id' => $request->barang_id,
        'harga' => $request->harga,
        'jumlah' => $request->jumlah,
    ]);

    return redirect()->route('penjualan.index')->with('success', 'Data berhasil diperbarui');
}

}
