<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        User::create(
            [
                'id' => 1,
                'name' => 'Admin',
                'role' => 'admin',
                'email' => 'admin@demo.com',
                'password' => Hash::make('password'),
            ]
        );
        User::create(
            [
                'id' => 2,
                'name' => 'Ade Purnawati, S.E.I',
                'role' => 'admin',
                'email' => 'cecepmansur@cv.net.id',
                'password' => Hash::make('password'),
            ]
        );
        User::create(
            [
                'id' => 3,
                'name' => 'Mahmud Anggraini',
                'role' => 'sales',
                'email' => 'upikhakim@perum.my.id',
                'password' => Hash::make('password'),
            ]
        );
        User::create(
            [
                'id' => 4,
                'name' => 'Puti Ana Adriansyah',
                'role' => 'sales',
                'email' => 'zutami@yahoo.com',
                'password' => Hash::make('password'),
            ]
        );
        User::create(
            [
                'id' => 5,
                'name' => 'Agung Hidayatullah',
                'role' => 'sales',
                'email' => 'agung@toko.com',
                'password' => Hash::make('password'),
            ]
        );
        User::create(
            [
                'id' => 6,
                'name' => 'Siti Nurhaliza',
                'role' => 'sales',
                'email' => 'siti@toko.com',
                'password' => Hash::make('password'),
            ]
        );
        User::create(
            [
                'id' => 7,
                'name' => 'Rudi Hartono',
                'role' => 'sales',
                'email' => 'rudi@toko.com',
                'password' => Hash::make('password'),
            ]
        );
        User::create(
            [
                'id' => 8,
                'name' => 'Nur Aisyah',
                'role' => 'sales',
                'email' => 'aisyah@toko.com',
                'password' => Hash::make('password'),
            ]
        );
        User::create(
            [
                'id' => 9,
                'name' => 'Fajar Rizki',
                'role' => 'sales',
                'email' => 'fajar@toko.com',
                'password' => Hash::make('password'),
            ]
        );
        User::create(
            [
                'id' => 10,
                'name' => 'Nina Wulandari',
                'role' => 'sales',
                'email' => 'nina@toko.com',
                'password' => Hash::make('password'),
            ]
        );
    }
}
