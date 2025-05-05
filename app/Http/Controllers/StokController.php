<?php
namespace App\Http\Controllers;

use App\Models\StokModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\BarangModel;
use Illuminate\Support\Facades\Auth;

class StokController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Stok',
            'list' => ['Home', 'Stok']
        ];

        $activeMenu = 'stok'; // Tambahkan active menu untuk navigasi
        return view('stok.index', compact('breadcrumb', 'activeMenu'));
    }

    public function create()
{
    $breadcrumb = (object) [
        'title' => 'Tambah Stok',
        'list' => ['Home', 'Stok', 'Tambah']
    ];

    $activeMenu = 'stok'; // Set active menu untuk sidebar
    $barang = BarangModel::all(); // Ambil semua data barang

    return view('stok.create', compact('breadcrumb', 'activeMenu', 'barang'));
}

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:m_barang,barang_id', // Pastikan barang ada
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer|min:1', // Pastikan jumlah stok valid
        ]);

        DB::transaction(function () use ($request) {
            StokModel::create([
                'barang_id' => $request->barang_id,
                'stok_tanggal' => $request->stok_tanggal,
                'stok_jumlah' => $request->stok_jumlah,
                'user_id' => Auth::id(),
                'supplier_id' => 1, // Pastikan nilai untuk kolom supplier_id diberikan
                'updated_at' => now(),
                'created_at' => now(),
            ]);
        });

        return redirect()->route('stok.index')->with('success', 'Data stok berhasil ditambahkan.');
    }

    public function list()
    {
        $data = StokModel::with(['barang', 'user'])->select('t_stok.*');
    
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $lihatDetail = '<a href="' . route('stok.show', $row->stok_id) . '" class="btn btn-info btn-sm mr-1">
                                    <i class="fas fa-eye"></i>
                                </a>';
            
                $edit = '<a href="' . route('stok.edit', $row->stok_id) . '" class="btn btn-warning btn-sm mr-1">
                            <i class="fas fa-edit"></i>
                        </a>';
            
                $hapus = '<button type="button" class="btn btn-danger btn-sm" onclick="hapusData(' . $row->stok_id . ')">
                            <i class="fas fa-trash"></i>
                        </button>';
            
                return '<div class="d-flex">' . $lihatDetail . $edit . $hapus . '</div>';
            })
            
            ->rawColumns(['aksi']) // Memastikan kolom aksi diproses sebagai raw HTML
            ->make(true);
    }

    public function show($id)
{
    $stok = StokModel::with(['barang', 'user'])->findOrFail($id); // Dapatkan detail stok dengan relasi

    return view('stok.show', compact('stok')); // Tampilkan ke view detail
}

public function edit($id)
{
    $stok = StokModel::findOrFail($id);
    $barang = BarangModel::all(); // Semua barang untuk dropdown

    return view('stok.edit', compact('stok', 'barang')); // Tampilkan ke view edit
}

public function update(Request $request, $id)
{
    $request->validate([
        'barang_id' => 'required|exists:m_barang,barang_id',
        'stok_tanggal' => 'required|date',
        'stok_jumlah' => 'required|integer|min:1',
    ]);

    DB::transaction(function () use ($request, $id) {
        $stok = StokModel::findOrFail($id);

        // Hitung perbedaan stok dan update stok barang
        $barang = BarangModel::findOrFail($stok->barang_id);
        $barang->stok -= $stok->stok_jumlah; // Kurangi stok lama
        $barang->stok += $request->stok_jumlah; // Tambahkan stok baru
        $barang->save();

        // Update data stok
        $stok->update([
            'barang_id' => $request->barang_id,
            'stok_tanggal' => $request->stok_tanggal,
            'stok_jumlah' => $request->stok_jumlah,
        ]);
    });

    return redirect()->route('stok.index')->with('success', 'Data stok berhasil diperbarui.');
}

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $stok = StokModel::findOrFail($id);

            // Kurangi stok dari m_barang
            $barang = BarangModel::findOrFail($stok->barang_id);
            $barang->stok -= $stok->stok_jumlah;
            $barang->save();

            // Hapus data dari t_stok
            $stok->delete();
        });

        return response()->json(['success' => true, 'message' => 'Data stok berhasil dihapus.']);
    }
}