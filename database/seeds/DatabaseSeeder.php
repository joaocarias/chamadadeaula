<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{    
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(EnderecoTableSeeder::class);
        $this->call(EscolaTableSeeder::class);
        $this->call(TipoProfissionalTable::class);
        $this->call(TurnoTable::class);
    }
}
