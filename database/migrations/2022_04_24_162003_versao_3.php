<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Versao3 extends Migration
{
    public function up()
    {
        Schema::create('loas', function (Blueprint $table) {
            $table->id();
            $table->longText('descricao')->nullable();
            $table->unsignedBigInteger('ploa_id')->nullable();
            $table->foreign('ploa_id')->references('id')->on('ploas');
            $table->string('tipo'); 
            $table->float('valor'); // 'entrada' ou 'bloqueio' (contigenciamento)
            $table->date('data_recebimento'); // 'entrada' ou 'bloqueio' (contigenciamento)
            $table->timestamps();
        });
    }

    public function down()
    {
        //
    }
}
