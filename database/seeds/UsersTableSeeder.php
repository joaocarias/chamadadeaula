<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{    
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',           
            'email' => 'admin@email.com',
            'email_verified_at' => now(),
            'password' => Hash::make('10203040'),            
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
