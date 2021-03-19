<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNullableTablePlanejamentoSemanals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('planejamento_semanals', function (Blueprint $table) {
            //

            $table->integer('trimestre')->nullable()->change();
            $table->string('periodo_semanal')->nullable()->change();

            //ALTER TABLE planejamento_semanals
//MODIFY COLUMN trimestre INT NULL;
//ALTER TABLE planejamento_semanals
//MODIFY COLUMN periodo_semanal VARChAR(255) NULL;
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
