<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{    
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrador',    
            'username' => '111.222.333-44',  
            'email' => 'administrador@chmada.com',
            'email_verified_at' => now(),
            'password' => Hash::make('102030'),            
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
