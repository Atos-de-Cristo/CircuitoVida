<?php
namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('users')->truncate();
        DB::table('permissions')->truncate();

        $this->call([ UsersTableSeeder::class, PermissionSeeder::class]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        User::factory(55)->hasAttached(Permission::find(3))->create();
    }
}
