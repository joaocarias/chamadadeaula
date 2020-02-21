<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditPlanejamentoSemanalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('planejamento_semanals', function (Blueprint $table) {
            $table->string('arquivo', 254)->nullable();
            
            $table->text('habilidades')->nullable()->change();
            $table->string('conteudo_tema', '255')->nullable()->change();            
            $table->text('metodologia')->nullable()->change();
            $table->text('recursos_didaticos')->nullable()->change();
            $table->text('como_sera_a_avaliacao')->nullable()->change();           
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
