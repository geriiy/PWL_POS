<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuplierModel extends Model
{
    use HasFactory;

        protected $table = 'm_supplier'; // Sesuaikan dengan nama tabel yang benar
    protected $primaryKey = 'supplier_id';

    protected $fillable = ['supplier_nama', 'supplier_alamat']; // Field yang bisa diisi
}
