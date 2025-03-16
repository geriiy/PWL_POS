<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\LevelModel;
use App\Models\KategoriModel;
use App\Models\SupplierModel;
use App\Models\BarangModel;

class DataController extends Controller
{
    // Menampilkan halaman data
    public function index()
    {
        return view('data.index');
    }

    // Ambil data Level
    public function getLevel()
    {
        $data = LevelModel::select('id', 'level_nama');
        return DataTables::of($data)->addIndexColumn()->make(true);
    }

    // Ambil data Kategori
    public function getKategori()
    {
        $data = KategoriModel::select('id', 'kategori_nama');
        return DataTables::of($data)->addIndexColumn()->make(true);
    }

    // Ambil data Supplier
    public function getSupplier()
    {
        $data = SupplierModel::select('id', 'supplier_nama', 'kontak');
        return DataTables::of($data)->addIndexColumn()->make(true);
    }

    // Ambil data Barang
    public function getBarang()
    {
        $data = BarangModel::select('id', 'barang_nama', 'harga', 'stok');
        return DataTables::of($data)->addIndexColumn()->make(true);
    }
}