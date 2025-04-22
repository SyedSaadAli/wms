<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Admin',  'slug' => Str::slug('Admin'), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Vendor', 'slug' => Str::slug('Vendor'), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'User',   'slug' => Str::slug('User'), 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('roles')->insert($roles);
    }
}
