<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Versao2 extends Migration
{
    public function up()
    {
        Schema::create('ploas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exercicio_id');
            $table->foreign('exercicio_id')->references('id')->on('exercicios');
            $table->unsignedBigInteger('programa_id');
            $table->foreign('programa_id')->references('id')->on('programas');
            $table->unsignedBigInteger('fonte_tipo_id');
            $table->foreign('fonte_tipo_id')->references('id')->on('fontes_tipos');
            $table->unsignedBigInteger('acao_tipo_id');
            $table->foreign('acao_tipo_id')->references('id')->on('acoes_tipos');
            $table->unsignedBigInteger('instituicao_id');
            $table->foreign('instituicao_id')->references('id')->on('instituicoes');
            $table->string('tipo_acao');
            $table->float('valor');
            $table->timestamps();
        });

        Schema::create('ploas_gestoras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ploa_id');
            $table->foreign('ploa_id')->references('id')->on('ploas');
            $table->unsignedBigInteger('unidade_gestora_id');
            $table->foreign('unidade_gestora_id')->references('id')->on('unidades_gestoras');
            $table->float('valor');
            $table->timestamps();
        });

        Schema::create('ploas_administrativas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ploa_gestora_id');
            $table->foreign('ploa_gestora_id')->references('id')->on('ploas_gestoras');
            $table->unsignedBigInteger('unidade_administrativa_id');
            $table->foreign('unidade_administrativa_id')->references('id')->on('unidades_administrativas');
            $table->float('valor');
            $table->timestamps();
        });

        Schema::table('naturezas_despesas', function (Blueprint $table) {
            $table->json('fields')->nullable();
        });

        Schema::table('subnaturezas_despesas', function (Blueprint $table) {
            $table->json('fields')->nullable();
        });

        Schema::create('despesas_modelos', function (Blueprint $table) {
            $table->id();
            $table->string('descricao')->nullable();
            $table->float('valor')->nullable();
            $table->float('valor_total')->nullable();
            $table->string('tipo')->nullable(); // fixa ou variável
            $table->unsignedBigInteger('centro_custo_id')->nullable();
            $table->foreign('centro_custo_id')->references('id')->on('centros_custos');
            $table->unsignedBigInteger('natureza_despesa_id')->nullable();
            $table->foreign('natureza_despesa_id')->references('id')->on('naturezas_despesas');
            $table->unsignedBigInteger('subnatureza_despesa_id')->nullable();
            $table->foreign('subnatureza_despesa_id')->references('id')->on('subnaturezas_despesas');
            $table->unsignedBigInteger('meta_id')->nullable();
            $table->foreign('meta_id')->references('id')->on('metas');
            $table->json('fields')->nullable();
            $table->timestamps();
        });


        // Tabela de Despesas
        Schema::create('despesas', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->float('valor');
            $table->float('valor_total')->nullable();
            $table->string('tipo')->nullable(); // fixa ou variável
            $table->unsignedBigInteger('ploa_administrativa_id');
            $table->foreign('ploa_administrativa_id')->references('id')->on('ploas_administrativas');
            $table->unsignedBigInteger('centro_custo_id');
            $table->foreign('centro_custo_id')->references('id')->on('centros_custos');
            $table->unsignedBigInteger('natureza_despesa_id');
            $table->foreign('natureza_despesa_id')->references('id')->on('naturezas_despesas');
            $table->unsignedBigInteger('subnatureza_despesa_id');
            $table->foreign('subnatureza_despesa_id')->references('id')->on('subnaturezas_despesas');
            $table->unsignedBigInteger('meta_id');
            $table->foreign('meta_id')->references('id')->on('metas');
            $table->unsignedBigInteger('despesa_modelo_id')->nullable();
            $table->foreign('despesa_modelo_id')->references('id')->on('despesas_modelos');
            $table->json('fields')->nullable();
            $table->timestamps();
        });

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
