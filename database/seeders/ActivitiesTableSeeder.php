<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ActivitiesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('activities')->insert([
            // Aktivitas untuk Lead ID 1
             [
                'lead_id' => 1,
                'type' => 'call',
                'description' => 'Telepon untuk penawaran awal',
                'date' => now()->subDays(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lead_id' => 2,
                'type' => 'email',
                'description' => 'Kirim katalog via email',
                'date' => now()->subDays(9),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lead_id' => 3,
                'type' => 'kunjungan',
                'description' => 'Kunjungan langsung ke toko',
                'date' => now()->subDays(8),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lead_id' => 4,
                'type' => 'call',
                'description' => 'Follow up hasil penawaran',
                'date' => now()->subDays(7),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lead_id' => 5,
                'type' => 'email',
                'description' => 'Kirim proposal kerjasama',
                'date' => now()->subDays(6),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lead_id' => 6,
                'type' => 'kunjungan',
                'description' => 'Kunjungan untuk demo produk',
                'date' => now()->subDays(5),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lead_id' => 7,
                'type' => 'call',
                'description' => 'Konfirmasi order masuk',
                'date' => now()->subDays(4),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lead_id' => 8,
                'type' => 'email',
                'description' => 'Tindak lanjut penolakan',
                'date' => now()->subDays(3),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lead_id' => 9,
                'type' => 'kunjungan',
                'description' => 'Beri informasi brosur terbaru',
                'date' => now()->subDays(2),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lead_id' => 10,
                'type' => 'call',
                'description' => 'Diskusi paket B lebih lanjut',
                'date' => now()->subDay(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
