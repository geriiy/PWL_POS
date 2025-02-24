<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenjualanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];
        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'penjualan_kode' => 'TRX' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'pembeli' => 'Customer ' . $i,
                'penjualan_tanggal' => Carbon::now(),
                'user_id' => rand(1, 3),
            ];
        }
        DB::table('t_penjualan')->insert($data);
    }
}
