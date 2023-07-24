<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('permissions')->insert([
            'permission' => 'admin'
        ]);
        DB::table('permissions')->insert([
            'permission' => 'monitor'
        ]);
        DB::table('permissions')->insert([
            'permission' => 'aluno'
        ]);
    }
}
