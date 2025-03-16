<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanModel extends Model
{
    use HasFactory;

    protected $table = 't_penjualan';
    protected $primaryKey = 'penjualan_id';
    public $timestamps = false;

    protected $fillable = ['tanggal'];

    // Relasi ke tabel PenjualanDetail
    public function details()
    {
        return $this->hasMany(PenjualanDetail::class, 'penjualan_id');
    }
}


