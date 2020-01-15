<?php

use Illuminate\Database\Seeder;

class EscolaTableSeeder extends Seeder
{    
    public function run()
    {
        DB::table('escolas')->insert([
            'prefeitura' => 'Prefeitura Municipal de Natal',           
            'secretaria' => 'Secretaria Municipal de Educação',           
            'escola' => 'CMEI Nossa Senhora de Lourdes',           
            'endereco_id' => 1,       
            'telefone' => '(84) 3615-2901',
            'usuario_cadastro' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}