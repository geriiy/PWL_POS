<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiModel extends Model
{
    use HasFactory;

    protected $table = 't_penjualan'; // Nama tabel di database

    protected $primaryKey = 'penjualan_id'; // Menentukan kolom primary key

    // Tentukan kolom yang dapat diisi (fillable)
    protected $fillable = [
        'user_id',
        'pembeli',
        'penjualan_kode',
        'penjualan_tanggal',
    ];

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }

    // Relasi dengan model PenjualanDetail
    public function details()
    {
        return $this->hasMany(PenjualanDetailModel::class, 'penjualan_id', 'penjualan_id');
    }

    // Aksesori untuk mendapatkan total penjualan (harga * jumlah) untuk semua barang dalam transaksi
    public function getTotalAttribute()
    {
        return $this->details->sum(function ($detail) {
            return $detail->harga * $detail->jumlah;
        });
    }
}
