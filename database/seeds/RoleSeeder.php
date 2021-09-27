<?php

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();

        Role::create(
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin',
            ]
        );
        Role::create(
            [
                'name' => 'Admin',
                'slug' => 'admin',
            ]
        );
        Role::create(
            [
                'name' => 'User',
                'slug' => 'user',
            ]
        );
    }
}
