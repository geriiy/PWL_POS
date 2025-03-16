<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{
    public function index()
    {
        $levels = LevelModel::all();
    
        $breadcrumb = (object) [
            'title' => 'Manajemen Level',
            'list' => ['Dashboard' => url('/'), 'Level' => route('level.index')]
        ];
    
        $activeMenu = 'level'; // Tambahkan ini untuk menentukan menu aktif
    
        return view('level.index', compact('levels', 'breadcrumb', 'activeMenu'));
    }
    




    public function create()
    {
        return view('level.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'level_nama' => 'required|string|max:100|unique:m_level,level_nama',
        ]);

        LevelModel::create($request->all());

        return redirect('/level')->with('success', 'Data level berhasil disimpan');
    }

    public function show($level_id)
{
    $level = LevelModel::findOrFail($level_id);
    return view('level.show', compact('level'));
}

public function edit($level_id)
{
    $level = LevelModel::findOrFail($level_id);
    return view('level.edit', compact('level'));
}

public function update(Request $request, $level_id)
{
    $level = LevelModel::findOrFail($level_id);
    $request->validate([
        'level_nama' => 'required|string|max:100|unique:m_level,level_nama,'.$level_id.',level_id',
    ]);

    $level->update($request->all());

    return redirect('/level')->with('success', 'Data level berhasil diperbarui');
}

public function destroy($level_id)
{
    $level = LevelModel::findOrFail($level_id);
    try {
        $level->delete();
        return redirect('/level')->with('success', 'Data level berhasil dihapus');
    } catch (\Illuminate\Database\QueryException $e) {
        return redirect('/level')->with('error', 'Data level gagal dihapus karena masih terdapat tabel lain yang terkait');
    }
}

}
