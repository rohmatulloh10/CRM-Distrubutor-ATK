<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccessesTableSeeder extends Seeder {
    public function run(): void {
        $accesses = [];

        $adminAccess = ['can_view' => 1, 'can_create' => 1, 'can_update' => 1, 'can_delete' => 1];
        $salesAccess = ['can_view' => 1, 'can_create' => 1, 'can_update' => 1, 'can_delete' => 0];

        for ($i = 1; $i <= 18; $i++) {
            // Admin full access
            $accesses[] = [
                'role' => 'admin',
                'menu_id' => $i,
                ...$adminAccess
            ];

            // Sales limited access
            if (in_array($i, [1, 6, 7, 9, 10, 12, 13])) {
                $accesses[] = [
                    'role' => 'sales',
                    'menu_id' => $i,
                    ...$salesAccess
                ];
            } elseif (in_array($i, [3, 4, 15, 16, 17, 18])) {
                $accesses[] = [
                    'role' => 'sales',
                    'menu_id' => $i,
                    'can_view' => 0,
                    'can_create' => 0,
                    'can_update' => 0,
                    'can_delete' => 0
                ];
            }
        }

        DB::table('accesses')->insert($accesses);
    }
}
