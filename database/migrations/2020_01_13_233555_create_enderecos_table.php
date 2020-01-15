<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnderecosTable extends Migration
{    
    public function up()
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('logradouro', 255);
            $table->string('numero', 10)->nullable(); 
            $table->string('bairro',255)->nullable();
            $table->string('complemento',255)->nullable();
            $table->string('cep', 10)->nullable();
            $table->string('cidade', 255);
            $table->string('uf', 2); 
            
            $table->unsignedBigInteger('usuario_cadastro');
            $table->foreign('usuario_cadastro')->references('id')->on('users');
            
            $table->softDeletes();
            $table->timestamps();
        });
    }
  
    public function down()
    {
        Schema::dropIfExists('enderecos');
    }
}
