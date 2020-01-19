<?php

use Illuminate\Database\Seeder;

class TipoProfissionalTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_profissionals')->insert([
            'nome' => 'Professor',            
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
