<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCamposTablePlanejamentoSemanals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('planejamento_semanals', function (Blueprint $table) {
            $table->text('conteudo_eu_o_outro_e_o_nos')->nullable()->change();
            $table->text('conteudo_corpo_gestos_e_movimentos')->nullable()->change();
            $table->text('conteudo_tracos_sons_cores_e_formas')->nullable()->change();
            $table->text('conteudo_escuta_fala_pensamento_e_imaginacao')->nullable()->change();
            $table->text('conteudo_espaco_tempo_qunatidades_relacoes_e_transformacoes')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('planejamento_semanals', function (Blueprint $table) {
            //
        });
    }
}
