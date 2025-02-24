<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StokSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];
        for ($i = 1; $i <= 15; $i++) {
            $data[] = [
                'barang_id' => $i,
                'supplier_id' => rand(1, 3),
                'user_id' => rand(1, 3), // Pastikan ada user_id yang valid
                'stok_tanggal' => Carbon::now(),
                'stok_jumlah' => rand(10, 100),
            ];
        }
        DB::table('t_stok')->insert($data);
    }
}
