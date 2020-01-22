<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurmaProfessorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turma_professors', function (Blueprint $table) {
            $table->bigIncrements('id');

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
        Schema::dropIfExists('turma_professors');
    }
}
