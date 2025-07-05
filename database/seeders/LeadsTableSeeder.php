<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class LeadsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('leads')->insert([
            ['store_id' => 1, 'created_by' => 3, 'status' => 'baru', 'notes' => 'Minat produk A', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['store_id' => 2, 'created_by' => 4, 'status' => 'follow_up', 'notes' => 'Minta diskon', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['store_id' => 3, 'created_by' => 5, 'status' => 'closing', 'notes' => 'Deal 20 unit', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['store_id' => 4, 'created_by' => 6, 'status' => 'gagal', 'notes' => 'Tidak tertarik', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['store_id' => 5, 'created_by' => 7, 'status' => 'baru', 'notes' => 'Akan dihubungi lagi', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['store_id' => 6, 'created_by' => 8, 'status' => 'follow_up', 'notes' => 'Minta presentasi', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['store_id' => 7, 'created_by' => 9, 'status' => 'closing', 'notes' => 'Order masuk', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['store_id' => 8, 'created_by' => 10, 'status' => 'gagal', 'notes' => 'Sudah punya supplier', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['store_id' => 9, 'created_by' => 3, 'status' => 'baru', 'notes' => 'Butuh brosur', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['store_id' => 10, 'created_by' => 4, 'status' => 'follow_up', 'notes' => 'Tertarik paket B', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
