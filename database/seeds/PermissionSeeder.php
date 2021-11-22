<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->delete();

        $permissions = [
            [
                'id' => '1',
                'title' => 'user management access',
                'slug' => 'user_management_access',
            ],
            [
                'id' => '2',
                'title' => 'permission create',
                'slug' => 'permission_create',
            ],
            [
                'id' => '3',
                'title' => 'permission edit',
                'slug' => 'permission_edit',
            ],
            [
                'id' => '4',
                'title' => 'permission delete',
                'slug' => 'permission_delete',
            ],
            [
                'id' => '5',
                'title' => 'permission access',
                'slug' => 'permission_access',
            ],
            [
                'id' => '6',
                'title' => 'role create',
                'slug' => 'role_create',
            ],
            [
                'id' => '7',
                'title' => 'role create',
                'slug' => 'role_create',
            ],
            [
                'id' => '8',
                'title' => 'role edit',
                'slug' => 'role_edit',
            ],
            [
                'id' => '9',
                'title' => 'role delete',
                'slug' => 'role delete',
            ],
            [
                'id' => '10',
                'title' => 'role access',
                'slug' => 'role_access',
            ]
        ];

        Permission::insert($permissions);
    }
}
