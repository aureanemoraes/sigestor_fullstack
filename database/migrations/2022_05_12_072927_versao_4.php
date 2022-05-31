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

        Schema::create('metas_orcamentarias', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->float('qtd_estimada')->nullable();
            $table->float('qtd_alcancada')->nullable();
            $table->unsignedBigInteger('natureza_despesa_id')->nullable();
            $table->foreign('natureza_despesa_id')->references('id')->on('naturezas_despesas');
            $table->unsignedBigInteger('acao_tipo_id')->nullable();
            $table->foreign('acao_tipo_id')->references('id')->on('acoes_tipos');
            $table->unsignedBigInteger('exercicio_id')->nullable();
            $table->foreign('exercicio_id')->references('id')->on('exercicios');
            $table->json('fields')->nullable();
            $table->timestamps();
        });

        Schema::create('metas_orcamentarias_responsaveis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meta_orcamentaria_id')->nullable();
            $table->foreign('meta_orcamentaria_id')->references('id')->on('metas_orcamentarias');
            $table->unsignedBigInteger('unidade_gestora_id')->nullable();
            $table->foreign('unidade_gestora_id')->references('id')->on('unidades_gestoras');
            $table->unsignedBigInteger('exercicio_id')->nullable();
            $table->foreign('exercicio_id')->references('id')->on('exercicios');
            $table->json('fields')->nullable();
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
