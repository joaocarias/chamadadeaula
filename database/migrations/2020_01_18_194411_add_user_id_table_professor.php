<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdTableProfessor extends Migration
{
    public function up()
    {
        Schema::table('professors', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('nome');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::table('professors', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
}
