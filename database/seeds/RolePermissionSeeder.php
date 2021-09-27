<?php

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_permission = Permission::all();
        Role::findOrFail(1)->permissions()->sync($admin_permission->pluck('id'));
    }
}
