<?php

use Illuminate\Database\Seeder;

class TurnoTable extends Seeder
{
    public function run()
    {
        DB::table('turnos')->insert([
            ['nome' => 'Matutino',            
            'created_at' => now(),
            'updated_at' => now()],

            ['nome' => 'Vespertino',            
            'created_at' => now(),
            'updated_at' => now()],

            ['nome' => 'Nortuno',            
            'created_at' => now(),
            'updated_at' => now()],

            ['nome' => 'Diurno',            
            'created_at' => now(),
            'updated_at' => now()],
        ]);
    }
}
