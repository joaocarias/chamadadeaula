<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableRelatoRevisao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('relatos', function (Blueprint $table) {  
            $table->boolean('revisado')->default(0);
            $table->unsignedBigInteger('usuario_revisor')->nullable();            
            $table->foreign('usuario_revisor')->references('id')->on('users');
            $table->dateTime('data_da_revisao')->nullable();                      
         });

         
//         ALTER TABLE planejamento_semanals 
    // ADD `usuario_revisor` BIGINT(20) DEFAULT NULL;

    // ALTER TABLE planejamento_semanals 
    // ADD  CONSTRAINT `planejamento_semanals_usuario_revisor_foreign` 
    // FOREIGN KEY (`usuario_revisor`) REFERENCES `users` (`id`)

//         ALTER TABLE planejamento_semanals 
    // ADD `data_da_revisao` DATETIME DEFAULT NULL;

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
