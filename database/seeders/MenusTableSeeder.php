<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenusTableSeeder extends Seeder {
    public function run(): void {
        DB::table('menus')->insert([
            // Dashboard
            ['id' => 1, 'name' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'fas fa-tachometer-alt', 'parent_id' => null, 'order' => 1],

            // Manajemen User
            ['id' => 2, 'name' => 'Manajemen User', 'route' => null, 'icon' => 'fas fa-users-cog', 'parent_id' => null, 'order' => 2],
            ['id' => 3, 'name' => 'Daftar User', 'route' => 'users.index', 'icon' => null, 'parent_id' => 2, 'order' => 1],
            ['id' => 4, 'name' => 'Tambah User', 'route' => 'users.create', 'icon' => null, 'parent_id' => 2, 'order' => 2],

            // Pelanggan
            ['id' => 5, 'name' => 'Pelanggan', 'route' => null, 'icon' => 'fas fa-user-friends', 'parent_id' => null, 'order' => 3],
            ['id' => 6, 'name' => 'Daftar Pelanggan', 'route' => 'customers.index', 'icon' => null, 'parent_id' => 5, 'order' => 1],
            ['id' => 7, 'name' => 'Tambah Pelanggan', 'route' => 'customers.create', 'icon' => null, 'parent_id' => 5, 'order' => 2],

            // Prospek
            ['id' => 8, 'name' => 'Prospek', 'route' => null, 'icon' => 'fas fa-bullseye', 'parent_id' => null, 'order' => 4],
            ['id' => 9, 'name' => 'Daftar Prospek', 'route' => 'leads.index', 'icon' => null, 'parent_id' => 8, 'order' => 1],
            ['id' => 10, 'name' => 'Tambah Prospek', 'route' => 'leads.create', 'icon' => null, 'parent_id' => 8, 'order' => 2],

            // Aktivitas
            ['id' => 11, 'name' => 'Aktivitas', 'route' => null, 'icon' => 'fas fa-tasks', 'parent_id' => null, 'order' => 5],
            ['id' => 12, 'name' => 'Daftar Aktivitas', 'route' => 'activities.index', 'icon' => null, 'parent_id' => 11, 'order' => 1],
            ['id' => 13, 'name' => 'Tambah Aktivitas', 'route' => 'activities.create', 'icon' => null, 'parent_id' => 11, 'order' => 2],

            // Laporan
            ['id' => 14, 'name' => 'Laporan', 'route' => null, 'icon' => 'fas fa-chart-bar', 'parent_id' => null, 'order' => 6],
            ['id' => 15, 'name' => 'Laporan Prospek', 'route' => 'reports.leads', 'icon' => null, 'parent_id' => 14, 'order' => 1],
            ['id' => 16, 'name' => 'Laporan Aktivitas', 'route' => 'reports.activities', 'icon' => null, 'parent_id' => 14, 'order' => 2],
            ['id' => 17, 'name' => 'Laporan Closing', 'route' => 'reports.closing', 'icon' => null, 'parent_id' => 14, 'order' => 3],
            ['id' => 18, 'name' => 'Export Excel/PDF', 'route' => 'reports.export', 'icon' => null, 'parent_id' => 14, 'order' => 4],

            // Logout (bisa ditaruh di layout, tidak harus di DB)
        ]);
    }
}

