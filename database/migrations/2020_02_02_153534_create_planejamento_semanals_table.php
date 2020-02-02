<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanejamentoSemanalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planejamento_semanals', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');

            $table->integer('ano');
            $table->string('tema_do_projeto');
            $table->integer('trimestre');
            $table->string('periodo_semana');
            $table->string('idade_faixa_etaria');
            $table->string('habilidades');
            $table->string('conteudo_tema');
            $table->boolean('eu_o_outro_e_o_nos')->default(0);
            $table->boolean('corpo_gestos_e_movimentos')->default(0);
            $table->boolean('tracos_sons_cores_e_formas')->default(0);
            $table->boolean('escuta_fala_pensamento_e_imaginacao')->default(0);
            $table->boolean('espaco_tempo_qunatidades_relacoes_e_transformacoes')->default(0);
            $table->string('metodologia');
            $table->string('recursos_didaticos');
            $table->string('como_sera_a_avaliacao');
            $table->string('coordenacao_pedagogica');
            $table->date('data_do_recebimento');

            $table->unsignedBigInteger('professor_id');
            $table->foreign('professor_id')->references('id')->on('profissionals');

            $table->unsignedBigInteger('turma_id');
            $table->foreign('turma_id')->references('id')->on('turmas');
            
            $table->unsignedBigInteger('usuario_cadastro');
            $table->foreign('usuario_cadastro')->references('id')->on('users');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planejamento_semanals');
    }
}
