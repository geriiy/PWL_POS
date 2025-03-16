<?php

namespace App\Http\Controllers;

use App\Models\SupplierModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = SupplierModel::all();
        return view('supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_nama' => 'required|string|max:100|unique:m_supplier,supplier_nama',
        ]);

        SupplierModel::create($request->all());

        return redirect('/supplier')->with('success', 'Data supplier berhasil disimpan');
    }

    public function show(SupplierModel $supplier)
    {
        return view('supplier.show', compact('supplier'));
    }

    public function edit(SupplierModel $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, SupplierModel $supplier)
    {
        $request->validate([
            'supplier_nama' => 'required|string|max:100|unique:m_supplier,supplier_nama,'.$supplier->supplier_id,
        ]);

        $supplier->update($request->all());

        return redirect('/supplier')->with('success', 'Data supplier berhasil diperbarui');
    }

    public function destroy(SupplierModel $supplier)
    {
        try {
            $supplier->delete();
            return redirect('/supplier')->with('success', 'Data supplier berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/supplier')->with('error', 'Data supplier gagal dihapus karena masih terdapat tabel lain yang terkait');
        }
    }
}
