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
      
        $users = [
            [
                'first_name'  => 'super',
                'last_name' => 'admin',
                'email' => 'admin@super.com',
                'phone' => '78478474574',          
                'password' => Hash::make('password'),
                'gender' => 'male',
                'role_id' => 1,
                'email_verified_at' => now()
            ],
            [
                'first_name'  => 'admin',
                'last_name' => 'admin',
                'email' => 'admin@admin.com',
                'phone' => '9841760946',         
                'password' => Hash::make('password'),           
                'gender' => 'male',
                'role_id' => 2,
                'email_verified_at' => now()
            ],
            [
                'first_name'  => 'user',
                'last_name' => 'user',
                'email' => 'user@user.com',
                'phone' => '9841760976',         
                'password' => Hash::make('password'),           
                'gender' => 'male',
                'role_id' => 3,
                'email_verified_at' => now()
            ],
        ];

        User::insert($users);

        // factory(User::class, 5)->states('admin')->create();

    }
}
