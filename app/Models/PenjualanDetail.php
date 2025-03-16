<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    use HasFactory;

    protected $table = 't_penjualan_detail';
    protected $primaryKey = 'detail_id';
    public $timestamps = false;

    protected $fillable = ['penjualan_id', 'barang_id', 'harga', 'jumlah'];

    // Relasi ke tabel Penjualan
    public function penjualan()
    {
        return $this->belongsTo(PenjualanModel::class, 'penjualan_id');
    }

    // Relasi ke tabel Barang
    public function barang()
    {
        return $this->belongsTo(BarangModel::class, 'barang_id');
    }
}
