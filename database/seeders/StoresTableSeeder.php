<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;


class StoresTableSeeder extends Seeder {
    public function run(): void {
        DB::table('stores')->insert([
            ['id' => 1, 'name' => 'Toko Sejahtera', 'owner_name' => 'Budi Santoso', 'phone' => '081234567890', 'address' => 'Jl. Mawar No.1', 'created_by' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'name' => 'Toko Makmur', 'owner_name' => 'Siti Aminah', 'phone' => '081234567891', 'address' => 'Jl. Melati No.2', 'created_by' => 4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'name' => 'Toko Sentosa', 'owner_name' => 'Rudi Hidayat', 'phone' => '081234567892', 'address' => 'Jl. Anggrek No.3', 'created_by' => 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 4, 'name' => 'Toko Bahagia', 'owner_name' => 'Dewi Sartika', 'phone' => '081234567893', 'address' => 'Jl. Kenanga No.4', 'created_by' => 6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 5, 'name' => 'Toko Mandiri', 'owner_name' => 'Joko Susilo', 'phone' => '081234567894', 'address' => 'Jl. Dahlia No.5', 'created_by' => 7, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 6, 'name' => 'Toko Jaya', 'owner_name' => 'Sri Rahayu', 'phone' => '081234567895', 'address' => 'Jl. Kamboja No.6', 'created_by' => 8, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 7, 'name' => 'Toko Baru', 'owner_name' => 'Ahmad Fauzi', 'phone' => '081234567896', 'address' => 'Jl. Mawar No.7', 'created_by' => 9, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 8, 'name' => 'Toko Super', 'owner_name' => 'Lina Marlina', 'phone' => '081234567897', 'address' => 'Jl. Melati No.8', 'created_by' => 10, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 9, 'name' => 'Toko Hebat', 'owner_name' => 'Wawan Setiawan', 'phone' => '081234567898', 'address' => 'Jl. Anggrek No.9', 'created_by' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 10, 'name' => 'Toko Prima', 'owner_name' => 'Dina Farida', 'phone' => '081234567899', 'address' => 'Jl. Kenanga No.10', 'created_by' => 4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        
    }
}

