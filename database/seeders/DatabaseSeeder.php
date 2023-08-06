<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('users')->truncate();
        DB::table('permissions')->truncate();

        $this->call([
            PermissionSeeder::class,
            UsersTableSeeder::class,
            // CategorySeeder::class,
            // EventSeeder::class,
            // ModuleSeeder::class,
            // LessonSeeder::class,
            // ActivitySeeder::class,
            // QuestionSeeder::class,
            // MonitorSeeder::class,
            // InscriptionSeeder::class,
            // FrequencySeeder::class,
            // ResponseSeeder::class,
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
