<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Versao2 extends Migration
{
    public function up()
    {
        // Tabela de Despesas
        // Schema::create('despesas', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('descricao');
        //     $table->float('valor');
        //     $table->float('valor_total');
        //     $table->integer('qtd')->default(1);
        //     $table->integer('qtd_pessoas')->default(1);
        //     $table->string('tipo'); // fixa ou variável
        //     $table->unsignedBigInteger('fonte_acao_id');
        //     $table->foreign('fonte_acao_id')->references('id')->on('fontes_acoes');
        //     $table->unsignedBigInteger('centro_custo_id');
        //     $table->foreign('centro_custo_id')->references('id')->on('centros_custos');
        //     $table->unsignedBigInteger('natureza_despesa_id');
        //     $table->foreign('natureza_despesa_id')->references('id')->on('naturezas_despesas');
        //     $table->unsignedBigInteger('subnatureza_despesa_id')->nullable();
        //     $table->foreign('subnatureza_despesa_id')->references('id')->on('subnaturezas_despesas');
        //     $table->unsignedBigInteger('unidade_administrativa_id')->nullable();
        //     $table->foreign('unidade_administrativa_id')->references('id')->on('unidades_administrativas');
        //     $table->unsignedBigInteger('exercicio_id')->nullable();
        //     $table->foreign('exercicio_id')->references('id')->on('exercicios');
        //     $table->timestamps();
        // });
        // Schema::create('movimentos', function (Blueprint $table) {
        //     $table->id();
        //     $table->longText('descricao');
        //     $table->float('valor');
        //     $table->unsignedBigInteger('exercicio_id')->nullable();
        //     $table->foreign('exercicio_id')->references('id')->on('exercicios');
        //     $table->string('tipo'); // 'entrada' ou 'bloqueio' (contigenciamento)
        //     $table->timestamps();
        // });
        // Schema::create('metas_orcamentarias', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('nome');
        //     $table->float('qtd_estimada')->nullable();
        //     $table->float('qtd_alcancada')->nullable();
        //     $table->unsignedBigInteger('natureza_despesa_id')->nullable();
        //     $table->foreign('natureza_despesa_id')->references('id')->on('naturezas_despesas');
        //     $table->unsignedBigInteger('acao_id')->nullable();
        //     $table->foreign('acao_id')->references('id')->on('acoes');
        //     $table->unsignedBigInteger('instituicao_id');
        //     $table->foreign('instituicao_id')->references('id')->on('instituicoes');
        //     $table->unsignedBigInteger('unidade_gestora_id');
        //     $table->foreign('unidade_gestora_id')->references('id')->on('unidades_gestoras');
        //     $table->unsignedBigInteger('exercicio_id')->nullable();
        //     $table->foreign('exercicio_id')->references('id')->on('exercicios');
        //     $table->timestamps();
        // });
        // Schema::create('limites_orcamentarios', function (Blueprint $table) {
        //     $table->id();
        //     $table->float('valor_solicitado');
        //     $table->float('valor_disponivel')->nullable();
        //     $table->string('numero_processo');
        //     $table->longText('descricao');
        //     $table->unsignedBigInteger('despesa_id');
        //     $table->foreign('despesa_id')->references('id')->on('despesas');
        //     $table->unsignedBigInteger('unidade_gestora_id')->nullable();
        //     $table->foreign('unidade_gestora_id')->references('id')->on('unidades_gestoras');
        //     $table->timestamps();
        // });
        // Schema::create('creditos_planejados', function (Blueprint $table) {
        //     $table->id();
        //     $table->longText('descricao');
        //     $table->float('valor_solicitado');
        //     $table->float('valor_disponivel')->nullable();
        //     $table->unsignedBigInteger('despesa_id');
        //     $table->foreign('despesa_id')->references('id')->on('despesas');
        //     $table->unsignedBigInteger('unidade_administrativa_id')->nullable();
        //     $table->foreign('unidade_administrativa_id')->references('id')->on('unidades_administrativas');
        //     $table->timestamps();
        // });
        // Schema::create('creditos_disponiveis', function (Blueprint $table) {
        //     $table->id();
        //     $table->longText('descricao');
        //     $table->float('valor_solicitado');
        //     $table->float('valor_disponivel')->nullable();
        //     $table->unsignedBigInteger('despesa_id');
        //     $table->foreign('despesa_id')->references('id')->on('despesas');
        //     $table->unsignedBigInteger('unidade_administrativa_id');
        //     $table->foreign('unidade_administrativa_id')->references('id')->on('unidades_administrativas');
        //     $table->timestamps();
        // });
        // Schema::create('empenhos', function (Blueprint $table) {
        //     $table->id();
        //     $table->float('valor_empenhado');
        //     $table->date('data_empenho');
        //     $table->unsignedBigInteger('credito_disponivel_id');
        //     $table->foreign('credito_disponivel_id')->references('id')->on('creditos_disponiveis');
        //     $table->unsignedBigInteger('unidade_administrativa_id');
        //     $table->foreign('unidade_administrativa_id')->references('id')->on('unidades_administrativas');
        //     $table->timestamps();
        // });
    }

    public function down()
    {

    }
}
