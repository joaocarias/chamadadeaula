<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTablePlanejamentoSemanalRevisaoBool extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('planejamento_semanals', function (Blueprint $table) {            
           $table->boolean('revisado')->default(0);
        });

//         ALTER TABLE planejamento_semanals 
    // ADD `revisado` BIT DEFAULT 0;
    
    // UPDATE planejamento_semanals
    // SET revisado = 0 
    // WHERE revisado is null;
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
