<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablePlanejamentoSemanalsAddArquivos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('planejamento_semanals', function (Blueprint $table) {
            $table->string('arquivo2', 254)->nullable();
            $table->string('arquivo3', 254)->nullable();
            $table->string('arquivo4', 254)->nullable();
            $table->string('arquivo5', 254)->nullable();
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
