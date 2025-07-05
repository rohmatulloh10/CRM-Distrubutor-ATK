<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LogActivitySeeder extends Seeder {
    public function run(): void {
        DB::table('log_activity')->insert([
            [
                'user_id' => 1, // Admin
                'action' => 'login',
                'module' => 'auth',
                'reference_id' => null,
                'description' => 'Login sebagai admin',
                'ip_address' => '192.168.1.10',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2, // Sales
                'action' => 'create',
                'module' => 'stores',
                'reference_id' => 1,
                'description' => 'Menambahkan Toko Alat Tulis Jaya',
                'ip_address' => '192.168.1.11',
                'user_agent' => 'Mozilla/5.0 (Android 11; Mobile)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'action' => 'update',
                'module' => 'leads',
                'reference_id' => 1,
                'description' => 'Memperbarui status lead menjadi "closing"',
                'ip_address' => '192.168.1.11',
                'user_agent' => 'Mozilla/5.0 (Android 11; Mobile)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'action' => 'create',
                'module' => 'activities',
                'reference_id' => 2,
                'description' => 'Menambahkan aktivitas kunjungan ke toko',
                'ip_address' => '192.168.1.11',
                'user_agent' => 'Mozilla/5.0 (Android 11; Mobile)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

