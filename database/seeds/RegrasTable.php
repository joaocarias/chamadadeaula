<?php

use Illuminate\Database\Seeder;

class RegrasTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regras')->insert([
            'nome' => 'ADMINISTRADOR',           
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
