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
                'title' => 'permission access',
                'slug' => 'permission_access',
            ],
            [
                'id' => '3',
                'title' => 'permission create',
                'slug' => 'permission_create',
            ],
            [
                'id' => '4',
                'title' => 'permission edit',
                'slug' => 'permission_edit',
            ],
            [
                'id' => '5',
                'title' => 'permission delete',
                'slug' => 'permission_delete',
            ],          
            [
                'id' => '6',
                'title' => 'role access',
                'slug' => 'role_access',
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
                'slug' => 'role_delete',
            ],
            [
                'id' => '10',
                'title' => 'page access',
                'slug' => 'page_access',
            ],
            [
                'id' => '11',
                'title' => 'page create',
                'slug' => 'page_create',
            ],
            [
                'id' => '12',
                'title' => 'page edit',
                'slug' => 'page_edit',
            ],
            [
                'id' => '13',
                'title' => 'page delete',
                'slug' => 'page_delete',
            ],
        ];

        Permission::insert($permissions);
    }
}
