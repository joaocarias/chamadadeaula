<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurmasTable extends Migration
{
    public function up()
    {
        Schema::create('turmas', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('nome', 255);
            $table->string('ano', 10);

            $table->unsignedBigInteger('turno_id');
            $table->foreign('turno_id')->references('id')->on('turnos');

            $table->unsignedBigInteger('usuario_cadastro');
            $table->foreign('usuario_cadastro')->references('id')->on('users');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('turmas');
    }
}
