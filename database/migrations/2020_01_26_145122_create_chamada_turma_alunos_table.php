<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChamadaTurmaAlunosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chamada_turma_alunos', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');

            $table->unsignedBigInteger('aluno_id');
            $table->foreign('aluno_id')->references('id')->on('alunos');

            $table->unsignedBigInteger('turma_id');
            $table->foreign('turma_id')->references('id')->on('turmas');
            
            $table->date('data_da_aula');
            $table->string('situacao');

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
        Schema::dropIfExists('chamada_turma_alunos');
    }
}
