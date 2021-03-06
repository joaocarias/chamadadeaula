<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterObrigatoriedadeTablePlanejamentoSemanals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('planejamento_semanals', function (Blueprint $table) {
            
            $table->unsignedBigInteger('turma_id')->nullable()->change();
          
            $table->unsignedBigInteger('professor_id')->nullable()->change();
            
            $table->integer('ano')->nullable()->change();

            $table->string('tema_do_projeto', '255')->nullable()->change();

            $table->string('idade_faixa_etaria')->nullable()->change();
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
