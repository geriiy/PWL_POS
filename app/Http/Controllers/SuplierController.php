<?php

namespace App\Http\Controllers;

use App\Models\SuplierModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\SupplierExport;
use App\Imports\SupplierImport;


class SuplierController extends Controller
{
    // Menampilkan halaman daftar suplier
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Suplier',
            'list' => ['Home', 'Suplier']
        ];

        $page = (object) [
            'title' => 'Daftar suplier yang tersedia dalam sistem'
        ];

        $activeMenu = 'suplier'; // set menu yang sedang aktif

        return view('suplier.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    // Ambil data suplier dalam bentuk JSON untuk DataTables
    public function list()
    {
        $supliers = SuplierModel::select('supplier_id', 'supplier_nama', 'supplier_alamat', 'created_at', 'updated_at');

        return DataTables::of($supliers)
            ->addIndexColumn()
            ->addColumn('aksi', function ($suplier) {
                $btn  = '<button onclick="modalAction(\''.url('/suplier/' . $suplier->suplier_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/suplier/' . $suplier->suplier_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/suplier/' . $suplier->suplier_id . '/delete_ajax').'\')"  class="btn btn-danger btn-sm">Hapus</button> '; 
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // Menampilkan halaman tambah suplier
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Suplier',
            'list' => ['Home', 'Suplier', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah suplier baru'
        ];

        $activeMenu = 'suplier'; // set menu yang sedang aktif

        return view('suplier.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan data suplier baru
    public function store(Request $request)
    {
        $request->validate([
            'supplier_nama' => 'required|string|max:100',
            'supplier_alamat' => 'required|string',
        ]);

        SuplierModel::create([
            'supplier_nama' => $request->supplier_nama,
            'supplier_alamat' => $request->supplier_alamat,
        ]);

        return redirect('/suplier')->with('success', 'Data suplier berhasil disimpan');
    }

    // Menampilkan detail suplier
    public function show(string $id)
    {
        $suplier = SuplierModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Suplier',
            'list' => ['Home', 'Suplier', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail suplier'
        ];

        $activeMenu = 'suplier'; // set menu yang sedang aktif

        return view('suplier.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'suplier' => $suplier, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form Edit suplier
    public function edit(string $id)
    {
        $suplier = SuplierModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Suplier',
            'list' => ['Home', 'Suplier', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit suplier'
        ];

        $activeMenu = 'suplier'; // set menu yang sedang aktif

        return view('suplier.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'suplier' => $suplier, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan perubahan data suplier
    public function update(Request $request, string $id)
    {
        $request->validate([
            'supplier_nama' => 'required|string|max:100',
            'supplier_alamat' => 'required|string',
        ]);

        $suplier = SuplierModel::findOrFail($id);
        $suplier->update([
            'supplier_nama' => $request->supplier_nama,
            'supplier_alamat' => $request->supplier_alamat,
        ]);

        return redirect('/suplier')->with('success', 'Data suplier berhasil diperbarui');
    }

    // Menghapus data suplier
    public function destroy(string $id)
    {
        $check = SuplierModel::find($id);
        if (!$check) {
            return redirect('/suplier')->with('error', 'Data suplier tidak ditemukan');
        }

        try {
            SuplierModel::destroy($id);
            return redirect('/suplier')->with('success', 'Data suplier berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/suplier')->with('error', 'Data suplier gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }


public function exportPdf()
{
    $supliers = SuplierModel::all();

    $pdf = Pdf::loadView('suplier.export_pdf', compact('supliers'))
              ->setPaper('A4', 'portrait');

    return $pdf->download('data-suplier.pdf');
}


public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv'
    ]);

    $path = $request->file('file')->getRealPath();

    $data = Excel::toCollection(null, $request->file('file'));

    if ($data->isEmpty()) {
        return redirect()->back()->with('error', 'File kosong atau tidak valid.');
    }

    // Ambil hanya sheet pertama
    $rows = $data[0];

    foreach ($rows as $index => $row) {
        if (!isset($row[0]) || !isset($row[1])) {
            continue; // skip jika kolom kosong
        }

        SuplierModel::create([
            'supplier_nama' => $row[0],
            'supplier_alamat' => $row[1],
        ]);
    }

    return redirect()->route('suplier.index')->with('success', 'Data suplier berhasil diimpor.');
}

public function export()
{
    $data = SuplierModel::all();

    $exportData = $data->map(function ($item) {
        return [
            'Nama Suplier'   => $item->supplier_nama,
            'Alamat Suplier' => $item->supplier_alamat,
            'Tanggal Input'  => optional($item->created_at)->format('Y-m-d H:i:s'),
        ];
    });

    return Excel::download(
        new \Maatwebsite\Excel\Collections\SheetCollection([
            'Data Suplier' => collect($exportData)
        ]),
        'data-suplier.xlsx'
    );
}
}
