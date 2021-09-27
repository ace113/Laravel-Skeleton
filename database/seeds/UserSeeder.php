<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // superadmin
         User::create([
            'first_name'  => 'super',
            'last_name' => 'admin',
            'email' => 'admin@super.com',
            'phone' => '78478474574',          
            'password' => Hash::make('password'),
            'gender' => 'male',
            'role_id' => 1
        ]);
        // admin
        User::create([
            'first_name'  => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@admin.com',
            'phone' => '9841760946',         
            'password' => Hash::make('password'),           
            'gender' => 'male',
            'role_id' => 2
        ]);
    }
}
