<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarangModel extends Model
{
    protected $table = 'm_barang'; // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'barang_id'; // Mendefinisikan primary key dari tabel yang digunakan

    protected $fillable = [
        'barang_kode', 'barang_nama', 'kategori_id', 'harga_beli', 'harga_jual', 'image'
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id', 'kategori_id');
    }

    public function stok()
    {
        return $this->hasMany(StokModel::class, 'barang_id', 'barang_id');
    }

    // Method untuk menghitung stok
    public function getStokAttribute()
    {
        return $this->stok()->sum('stok_jumlah'); // Hitung total stok berdasarkan data di t_stok
    }


    public function export_excel()
{
    // ambil data barang yang akan di export
    $barang = BarangModel::select('kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')
        ->orderBy('kategori_id')
        ->with('kategori')
        ->get();
}
}