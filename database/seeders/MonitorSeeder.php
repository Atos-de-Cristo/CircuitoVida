<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MonitorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('event_user')->insert([
            'event_id' => '1',
            'user_id' => '3'
        ]);
        DB::table('event_user')->insert([
            'event_id' => '1',
            'user_id' => '4'
        ]);
    }
}
