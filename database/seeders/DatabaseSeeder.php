<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
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

        $this->call([ UsersTableSeeder::class, PermissionSeeder::class]);

        User::factory(55)->hasAttached(Permission::find(3))->create();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
