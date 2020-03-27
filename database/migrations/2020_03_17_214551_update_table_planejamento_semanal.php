<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTablePlanejamentoSemanal extends Migration
{
    public function up()
    {
        Schema::table('planejamento_semanals', function (Blueprint $table) {
            
            $table->string('conteudo_eu_o_outro_e_o_nos', 255)->nullable();
            $table->string('conteudo_corpo_gestos_e_movimentos', 255)->nullable();
            $table->string('conteudo_tracos_sons_cores_e_formas', 255)->nullable();
            $table->string('conteudo_escuta_fala_pensamento_e_imaginacao', 255)->nullable();            
            $table->string('conteudo_espaco_tempo_qunatidades_relacoes_e_transformacoes', 255)->nullable();
        });

        
//         ALTER TABLE planejamento_semanals
//     ADD `conteudo_eu_o_outro_e_o_nos` VARCHAR(255);

// ALTER TABLE planejamento_semanals
// 	ADD `conteudo_corpo_gestos_e_movimentos` VARCHAR(255);
  
// ALTER TABLE planejamento_semanals
// 	ADD `conteudo_tracos_sons_cores_e_formas` VARCHAR(255);

// ALTER TABLE planejamento_semanals
// 	ADD `conteudo_escuta_fala_pensamento_e_imaginacao` VARCHAR(255);

// ALTER TABLE planejamento_semanals
// 	ADD `conteudo_espaco_tempo_qunatidades_relacoes_e_transformacoes` VARCHAR(255);        
    }

    public function down()
    {
        
    }
}
