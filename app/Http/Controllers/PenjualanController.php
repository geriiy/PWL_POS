<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanModel;
use App\Models\PenjualanDetailModel;
use App\Models\BarangModel;
use Yajra\DataTables\Facades\DataTables; // <= Perbaiki use DataTables
use Illuminate\Support\Facades\Auth;     // <= Perbaiki use Auth

class PenjualanController extends Controller
{
    public function index()
{
    $breadcrumb = (object)[
        'title' => 'Data Penjualan',
        'list' => ['Home', 'Penjualan']
    ];

    return view('transaksi.index', [
        'activeMenu' => 'penjualan',
        'breadcrumb' => $breadcrumb,
    ]);
}

    public function list()
{
    $penjualan = PenjualanModel::with('user')->orderBy('penjualan_tanggal', 'desc')->get();

    return DataTables::of($penjualan)
        ->addIndexColumn()
        ->addColumn('aksi', function ($row) {
            return '
                <a href="' . route('penjualan.show', $row->penjualan_id) . '" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                <button onclick="hapusData(' . $row->penjualan_id . ')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
            ';
        })
        ->rawColumns(['aksi'])
        ->make(true);
}


public function create()
{
    $breadcrumb = (object)[
        'title' => 'Tambah Penjualan',
        'list' => ['Home', 'Penjualan', 'Tambah']
    ];

    $barang = BarangModel::all();
    return view('transaksi.create', [
        'barang' => $barang,
        'activeMenu' => 'penjualan',
        'breadcrumb' => $breadcrumb,
    ]);
}

public function show($id)
{
    $breadcrumb = (object)[
        'title' => 'Detail Penjualan',
        'list' => ['Home', 'Penjualan', 'Detail']
    ];

    $penjualan = PenjualanModel::with('detail.barang')->findOrFail($id);
    return view('penjualan.show', compact('penjualan', 'breadcrumb'));
}

public function store(Request $request)
{
    $request->validate([
        'pembeli' => 'required|string|max:255',
        'barang_id' => 'required|array',
        'jumlah' => 'required|array',
    ]);

    $penjualan = PenjualanModel::create([
        'user_id' => Auth::id(),
        'pembeli' => $request->pembeli,
        'penjualan_kode' => 'PJ' . date('YmdHis'),
        'penjualan_tanggal' => now(),
    ]);

    foreach ($request->barang_id as $key => $barang_id) {
        $barang = BarangModel::findOrFail($barang_id);
    
        // Periksa apakah stok mencukupi
        if ($barang->stok < $request->jumlah[$key]) {
            return redirect()->back()->with('error', 'Stok barang tidak mencukupi untuk barang: ' . $barang->barang_nama);
        }
    
        // Kurangi stok
        $barang->stok -= $request->jumlah[$key];
        $barang->save();
    
        // Simpan detail penjualan
        PenjualanDetailModel::create([
            'penjualan_id' => $penjualan->penjualan_id,
            'barang_id' => $barang_id,
            'harga' => $barang->harga_jual,
            'jumlah' => $request->jumlah[$key],
        ]);
    }

    return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan!');
}


    public function destroy($id)
    {
        $penjualan = PenjualanModel::findOrFail($id);
        $penjualan->detail()->delete();
        $penjualan->delete();

        return response()->json(['message' => 'Data berhasil dihapus!']);
    }
}
