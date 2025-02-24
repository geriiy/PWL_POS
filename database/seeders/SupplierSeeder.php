<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['supplier_kode' => 'SUP001', 'supplier_nama' => 'PT Sumber Makmur', 'supplier_alamat' => 'Jakarta'],
            ['supplier_kode' => 'SUP002', 'supplier_nama' => 'CV Mitra Sejahtera', 'supplier_alamat' => 'Surabaya'],
            ['supplier_kode' => 'SUP003', 'supplier_nama' => 'UD Aneka Jaya', 'supplier_alamat' => 'Bandung'],
        ];
        DB::table('m_supplier')->insert($data);
    }
}
