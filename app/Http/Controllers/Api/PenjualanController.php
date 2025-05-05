<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PenjualanModel;
use Illuminate\Support\Facades\Storage;

class PenjualanController extends Controller
{
    public function index()
    {
        return PenjualanModel::with('user')->get();
    }

    public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:m_user,user_id',
        'pembeli' => 'required|string|max:50',
        'penjualan_kode' => 'required|string|max:20|unique:t_penjualan',
        'penjualan_tanggal' => 'required|date',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ]);

    $data = $request->all();

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('penjualan', 'public');
    }

    $penjualan = PenjualanModel::create($data);

    return response()->json($penjualan, 201);
}


    public function show($id)
    {
        return PenjualanModel::with('user')->findOrFail($id);
    }

    public function update(Request $request, $id)
{
    $penjualan = PenjualanModel::findOrFail($id);

    $request->validate([
        'user_id' => 'sometimes|exists:m_user,user_id',
        'pembeli' => 'sometimes|string|max:50',
        'penjualan_kode' => 'sometimes|string|max:20|unique:t_penjualan,penjualan_kode,' . $id . ',penjualan_id',
        'penjualan_tanggal' => 'sometimes|date',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ]);

    $data = $request->all();

    if ($request->hasFile('image')) {
        // Hapus file lama jika ada
        if ($penjualan->image && Storage::disk('public')->exists($penjualan->image)) {
            Storage::disk('public')->delete($penjualan->image);
        }

        $data['image'] = $request->file('image')->store('penjualan', 'public');
    }

    $penjualan->update($data);

    return response()->json($penjualan);
}


    public function destroy($id)
    {
        $penjualan = PenjualanModel::findOrFail($id);
        $penjualan->delete();

        return response()->json(['message' => 'Transaksi berhasil dihapus.']);
    }
}
