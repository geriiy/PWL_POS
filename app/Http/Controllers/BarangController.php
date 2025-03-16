<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class BarangController extends Controller
{
    public function index()
    {
        // Mengambil semua data barang beserta kategori & supplier
        $barangs = BarangModel::with(['kategori', 'supplier'])->get();


        // Kirim data ke view
        return view('barang.index', ['barangs' => BarangModel::all(), 'activeMenu' => 'barang'], compact('barangs'));
    }

    public function list()
    {
        $barang = BarangModel::select('barang_id', 'barang_nama', 'kategori_id', 'supplier_id', 'harga', 'stok');
        return DataTables::of($barang)
            ->addIndexColumn()
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_nama' => 'required|string|max:100|unique:m_barang,barang_nama',
            'kategori_id' => 'required|integer',
            'supplier_id' => 'required|integer',
            'harga' => 'required|numeric',
            'stok' => 'required|integer'
        ]);
        BarangModel::create($request->all());
        return redirect('/barang')->with('success', 'Data barang berhasil disimpan');
    }

    public function stok()
    {
        $stok = DB::table('m_barang')
    ->join('t_stok', 'm_barang.barang_id', '=', 't_stok.barang_id')
    ->select('m_barang.barang_nama', 't_stok.stok_jumlah', 't_stok.stok_tanggal')
    ->get();

        return view('barang.stok', compact('stok'))->with('activeMenu', 'stok');
    }

    public function destroy($id)
{
    $barang = BarangModel::findOrFail($id); // Cari barang berdasarkan ID
    $barang->delete(); // Hapus barang

    return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus');
}


}
