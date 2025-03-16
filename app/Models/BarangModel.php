<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangModel extends Model
{
    use HasFactory;

    protected $table = 'm_barang'; // Sesuaikan dengan nama tabel di database
    protected $primaryKey = 'barang_id'; // Pastikan ini sesuai dengan primary key di tabel
    protected $fillable = ['barang_nama', 'kategori_id', 'supplier_id', 'harga', 'stok'];

    // Relasi ke kategori
    public function kategori()
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id', 'kategori_id');
    }

    // Relasi ke supplier
    public function supplier()
    {
        return $this->belongsTo(SupplierModel::class, 'supplier_id', 'supplier_id');
    }
}
