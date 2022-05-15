<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Versao4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remanejamentos', function (Blueprint $table) {
            $table->id();
            $table->float('valor');
            $table->string('numero_oficio');
            $table->date('data');
            $table->unsignedBigInteger('despesa_remetente_id');
            $table->foreign('despesa_remetente_id')->references('id')->on('despesas');
            $table->unsignedBigInteger('unidade_gestora_id')->nullable();
            $table->foreign('unidade_gestora_id')->references('id')->on('unidades_gestoras');
            $table->unsignedBigInteger('instituicao_id')->nullable();
            $table->foreign('instituicao_id')->references('id')->on('instituicoes');
            $table->timestamps();
        });

        Schema::create('remanejamentos_destinatarios', function (Blueprint $table) {
            $table->id();
            $table->float('valor');
            $table->unsignedBigInteger('remanejamento_id');
            $table->foreign('remanejamento_id')->references('id')->on('remanejamentos');
            $table->unsignedBigInteger('despesa_destinatario_id');
            $table->foreign('despesa_destinatario_id')->references('id')->on('despesas');
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
        //
    }
}
