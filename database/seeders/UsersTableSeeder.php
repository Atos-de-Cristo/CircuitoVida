<?php
namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Wesley Teixeira',
            'email' => 'contato@wesleyteixeira.com.br',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('users')->insert([
            'id' => 2,
            'name' => 'Berguison paiva',
            'email' => 'pberguison@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        User::factory()->count(55)->hasAttached(Permission::find(3))->create();
        User::find(1)->givePermissionTo('admin');
        User::find(2)->givePermissionTo('admin');
        User::find(3)->givePermissionTo('monitor');
        User::find(4)->givePermissionTo('monitor');
        User::find(5)->givePermissionTo('monitor');
    }
}
