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
        DB::table('tipo_profissionals')->insert(
            [
                [
                    'id' => '1',
                    'nome' => 'PROFESSOR (A)',            
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => '2',
                    'nome' => 'SERVIÇOS GERAIS',            
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => '3',
                    'nome' => 'AUXILIAR/ASSISTENTE EDUC.',            
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => '4',
                    'nome' => 'COORD. PEDAGÓGICO(A)',            
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => '5',
                    'nome' => 'DIRETOR(A) PEDAGÓGICO',            
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => '6',
                    'nome' => 'AUXILIAR DE COZINHA',            
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => '7',
                    'nome' => 'ASSISTENTE SECRETARIADO',            
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => '8',
                    'nome' => 'PORTEIRO',            
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
    }
}
