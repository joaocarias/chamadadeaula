<?php

use Illuminate\Database\Seeder;

class EnderecoTableSeeder extends Seeder
{    
    public function run()
    {
        DB::table('enderecos')->insert([
            'logradouro' => 'Rua João XXIII',           
            'numero' => '1215',
            'bairro' => 'Mãe Luíza',                        
            'cep' => '59.014-000',
            'cidade' => 'Natal',
            'uf' => 'RN',
            'usuario_cadastro' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}

