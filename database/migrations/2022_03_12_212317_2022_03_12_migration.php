<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Migration20220122 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Tabela de Instituições
        Schema::create('instituicoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('sigla')->nullable();
            $table->string('cnpj');
            $table->string('uasg');
            $table->string('logradouro')->nullable();
            $table->string('numero')->nullable();
            $table->string('bairro')->nullable();
            $table->string('complemento')->nullable();
            $table->timestamps();
        });
        // Tabela de Exercícios
        Schema::create('exercicios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->unsignedBigInteger('instituicao_id');
            $table->foreign('instituicao_id')->references('id')->on('instituicoes');
            $table->timestamps();
        });
        // Tabela de Unidades Gestoras
        Schema::create('unidades_gestoras', function (Blueprint $table) {
            // nome da pessoa
            // titulacao
            $table->id();
            $table->string('nome');
            $table->string('sigla')->nullable();
            $table->string('cnpj');
            $table->string('uasg');
            $table->string('logradouro')->nullable();
            $table->string('numero')->nullable();
            $table->string('bairro')->nullable();
            $table->string('complemento')->nullable();
            $table->json('logs')->nullable();
            $table->unsignedBigInteger('instituicao_id');
            $table->foreign('instituicao_id')->references('id')->on('instituicoes');
            // $table->unsignedBigInteger('usuario_exclusao_id');
            // $table->foreign('usuario_exclusao_id')->references('id')->on('usuarios');
            $table->softDeletes();
            $table->timestamps();
        });
        // Tabela de Unidades Administrativas
        Schema::create('unidades_administrativas', function (Blueprint $table) {
            // gestor
            $table->id();
            $table->string('nome');
            $table->string('sigla')->nullable();
            $table->string('ugr');
            $table->json('logs')->nullable();
            $table->unsignedBigInteger('instituicao_id');
            $table->foreign('instituicao_id')->references('id')->on('instituicoes');
            $table->unsignedBigInteger('unidade_gestora_id');
            $table->foreign('unidade_gestora_id')->references('id')->on('unidades_gestoras');
            // $table->unsignedBigInteger('usuario_exclusao_id');
            // $table->foreign('usuario_exclusao_id')->references('id')->on('usuarios');
            $table->softDeletes();
            $table->timestamps();
        });
         // Tabela de Usuários
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cpf');
            $table->string('password');
            $table->string('perfil');
            $table->tinyInteger('ativo')->default(0);
            $table->unsignedBigInteger('instituicao_id')->nullable();
            $table->foreign('instituicao_id')->references('id')->on('instituicoes');
            $table->unsignedBigInteger('unidade_gestora_id')->nullable();
            $table->foreign('unidade_gestora_id')->references('id')->on('unidades_gestoras');
            $table->unsignedBigInteger('unidade_administrativa_id')->nullable();
            $table->foreign('unidade_administrativa_id')->references('id')->on('unidades_administrativas');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
        // Tabela de Passwords Resets
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
        Schema::create('planos_estrategicos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->unsignedBigInteger('instituicao_id');
            $table->foreign('instituicao_id')->references('id')->on('instituicoes');
            $table->timestamps();
        });
        Schema::create('eixos_estrategicos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->unsignedBigInteger('plano_estrategico_id');
            $table->foreign('plano_estrategico_id')->references('id')->on('planos_estrategicos');
            $table->unsignedBigInteger('instituicao_id');
            $table->foreign('instituicao_id')->references('id')->on('instituicoes');
            $table->timestamps();
        });
        Schema::create('planos_acoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->unsignedBigInteger('plano_estrategico_id');
            $table->foreign('plano_estrategico_id')->references('id')->on('planos_estrategicos');
            $table->unsignedBigInteger('instituicao_id');
            $table->foreign('instituicao_id')->references('id')->on('instituicoes');
            $table->timestamps();
        });
        Schema::create('dimensoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->unsignedBigInteger('eixo_estrategico_id');
            $table->foreign('eixo_estrategico_id')->references('id')->on('eixos_estrategicos');
            $table->unsignedBigInteger('instituicao_id');
            $table->foreign('instituicao_id')->references('id')->on('instituicoes');
            $table->timestamps();
        });

        Schema::create('objetivos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->tinyInteger('ativo')->default(1);
            $table->unsignedBigInteger('dimensao_id');
            $table->foreign('dimensao_id')->references('id')->on('dimensoes');
            $table->timestamps();
        });

        Schema::create('metas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->longText('descricao')->nullable();
            $table->string('tipo');
            $table->string('valor_inicial');
            $table->string('valor_final');
            $table->string('valor_atingido')->nullable();
            $table->unsignedBigInteger('objetivo_id');
            $table->foreign('objetivo_id')->references('id')->on('objetivos');
            $table->unsignedBigInteger('unidade_gestora_id');
            $table->foreign('unidade_gestora_id')->references('id')->on('unidades_gestoras');
            $table->timestamps();
        });
        // Tabela de GruposFontes
        Schema::create('grupos_fontes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->tinyInteger('fav')->default(0);
            $table->timestamps();
        });
        // Tabela de Espeficacoes
        Schema::create('especificacoes', function (Blueprint $table) {
            $table->id()->from(0);
            $table->string('nome');
            $table->tinyInteger('fav')->default(0);
            $table->timestamps();
        });
        // Tabela FontesTipos
        Schema::create('fontes_tipos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('grupo_fonte_id');
            $table->foreign('grupo_fonte_id')->references('id')->on('grupos_fontes');
            $table->unsignedBigInteger('especificacao_id');
            $table->foreign('especificacao_id')->references('id')->on('especificacoes');
            $table->tinyInteger('fav')->default(0);
            $table->string('nome');
            $table->string('codigo')->nullable();
            $table->timestamps();
        });
        // Tabela Fontes
        Schema::create('fontes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fonte_tipo_id');
            $table->foreign('fonte_tipo_id')->references('id')->on('fontes_tipos');
            $table->unsignedBigInteger('exercicio_id');
            $table->foreign('exercicio_id')->references('id')->on('exercicios');
            $table->unsignedBigInteger('instituicao_id');
            $table->foreign('instituicao_id')->references('id')->on('instituicoes');
            $table->tinyInteger('fav')->default(0);
            $table->float('valor');
            $table->timestamps();
        });
        // Tabela Ações Tipos
        Schema::create('acoes_tipos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('codigo');
            $table->tinyInteger('custeio')->default(0);
            $table->tinyInteger('investimento')->default(0);
            $table->tinyInteger('fav')->default(0);
            $table->timestamps();
        });
        // Tabela Ações
        Schema::create('acoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('acao_tipo_id');
            $table->foreign('acao_tipo_id')->references('id')->on('acoes_tipos');
            $table->unsignedBigInteger('exercicio_id');
            $table->tinyInteger('fav')->default(0);
            $table->foreign('exercicio_id')->references('id')->on('exercicios');
            $table->unsignedBigInteger('instituicao_id');
            $table->foreign('instituicao_id')->references('id')->on('instituicoes');
            $table->timestamps();
        });
        // Tabela Fontes Ações
        Schema::create('fontes_acoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fonte_id');
            $table->foreign('fonte_id')->references('id')->on('fontes');
            $table->unsignedBigInteger('acao_id');
            $table->foreign('acao_id')->references('id')->on('acoes');
            $table->unsignedBigInteger('exercicio_id');
            $table->foreign('exercicio_id')->references('id')->on('exercicios');
            $table->unsignedBigInteger('instituicao_id')->nullable();
            $table->foreign('instituicao_id')->references('id')->on('instituicoes');
            $table->unsignedBigInteger('unidade_gestora_id')->nullable();
            $table->foreign('unidade_gestora_id')->references('id')->on('unidades_gestoras');
            $table->unsignedBigInteger('unidade_administrativa_id')->nullable();
            $table->foreign('unidade_administrativa_id')->references('id')->on('unidades_administrativas');
            $table->float('valor');
            $table->timestamps();
        });
        // Tabela Programas
        Schema::create('programas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->string('nome');
            $table->tinyInteger('fav')->default(0);
            $table->timestamps();
        });
        // Tabela Fontes Programas
        Schema::create('fontes_programas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fonte_id');
            $table->foreign('fonte_id')->references('id')->on('fontes');
            $table->unsignedBigInteger('programa_id');
            $table->foreign('programa_id')->references('id')->on('programas');
            $table->unsignedBigInteger('exercicio_id');
            $table->foreign('exercicio_id')->references('id')->on('exercicios');
            $table->timestamps();
        });
        // Tabela de Naturezas Despesas
        Schema::create('naturezas_despesas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('codigo');
            $table->string('tipo');
            $table->tinyInteger('fav')->default(0);
            $table->timestamps();
        });
        // Tabela de Subnaturezas Despesas
        Schema::create('subnaturezas_despesas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('codigo');
            $table->unsignedBigInteger('natureza_despesa_id');
            $table->foreign('natureza_despesa_id')->references('id')->on('naturezas_despesas');
            $table->timestamps();
        });
        // Tabela de Centro Custo
        Schema::create('centros_custos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->timestamps();
        });
        // Tabela de Despesas
        Schema::create('despesas', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->float('valor');
            $table->float('valor_total');
            $table->integer('qtd')->default(1);
            $table->integer('qtd_pessoas')->default(1);
            $table->string('tipo'); // fixa ou variável
            $table->unsignedBigInteger('fonte_acao_id');
            $table->foreign('fonte_acao_id')->references('id')->on('fontes_acoes');
            $table->unsignedBigInteger('centro_custo_id');
            $table->foreign('centro_custo_id')->references('id')->on('centros_custos');
            $table->unsignedBigInteger('natureza_despesa_id');
            $table->foreign('natureza_despesa_id')->references('id')->on('naturezas_despesas');
            $table->unsignedBigInteger('subnatureza_despesa_id')->nullable();
            $table->foreign('subnatureza_despesa_id')->references('id')->on('subnaturezas_despesas');
            $table->unsignedBigInteger('unidade_administrativa_id')->nullable();
            $table->foreign('unidade_administrativa_id')->references('id')->on('unidades_administrativas');
            $table->unsignedBigInteger('exercicio_id')->nullable();
            $table->foreign('exercicio_id')->references('id')->on('exercicios');
            $table->timestamps();
        });
        Schema::create('movimentos', function (Blueprint $table) {
            $table->id();
            $table->longText('descricao');
            $table->float('valor');
            $table->unsignedBigInteger('exercicio_id')->nullable();
            $table->foreign('exercicio_id')->references('id')->on('exercicios');
            $table->string('tipo'); // 'entrada' ou 'bloqueio' (contigenciamento)
            $table->timestamps();
        });
        Schema::create('metas_orcamentarias', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->float('qtd_estimada')->nullable();
            $table->float('qtd_alcancada')->nullable();
            $table->unsignedBigInteger('natureza_despesa_id')->nullable();
            $table->foreign('natureza_despesa_id')->references('id')->on('naturezas_despesas');
            $table->unsignedBigInteger('acao_id')->nullable();
            $table->foreign('acao_id')->references('id')->on('acoes');
            $table->unsignedBigInteger('instituicao_id');
            $table->foreign('instituicao_id')->references('id')->on('instituicoes');
            $table->unsignedBigInteger('unidade_gestora_id');
            $table->foreign('unidade_gestora_id')->references('id')->on('unidades_gestoras');
            $table->unsignedBigInteger('exercicio_id')->nullable();
            $table->foreign('exercicio_id')->references('id')->on('exercicios');
            $table->timestamps();
        });
        Schema::create('limites_orcamentarios', function (Blueprint $table) {
            $table->id();
            $table->float('valor_solicitado');
            $table->float('valor_disponivel')->nullable();
            $table->string('numero_processo');
            $table->longText('descricao');
            $table->unsignedBigInteger('despesa_id');
            $table->foreign('despesa_id')->references('id')->on('despesas');
            $table->unsignedBigInteger('unidade_gestora_id')->nullable();
            $table->foreign('unidade_gestora_id')->references('id')->on('unidades_gestoras');
            $table->timestamps();
        });
        Schema::create('creditos_planejados', function (Blueprint $table) {
            $table->id();
            $table->longText('descricao');
            $table->float('valor_solicitado');
            $table->float('valor_disponivel')->nullable();
            $table->unsignedBigInteger('despesa_id');
            $table->foreign('despesa_id')->references('id')->on('despesas');
            $table->unsignedBigInteger('unidade_administrativa_id')->nullable();
            $table->foreign('unidade_administrativa_id')->references('id')->on('unidades_administrativas');
            $table->timestamps();
        });
        Schema::create('creditos_disponiveis', function (Blueprint $table) {
            $table->id();
            $table->longText('descricao');
            $table->float('valor_solicitado');
            $table->float('valor_disponivel')->nullable();
            $table->unsignedBigInteger('despesa_id');
            $table->foreign('despesa_id')->references('id')->on('despesas');
            $table->unsignedBigInteger('unidade_administrativa_id');
            $table->foreign('unidade_administrativa_id')->references('id')->on('unidades_administrativas');
            $table->timestamps();
        });
        Schema::create('empenhos', function (Blueprint $table) {
            $table->id();
            $table->float('valor_empenhado');
            $table->date('data_empenho');
            $table->unsignedBigInteger('credito_disponivel_id');
            $table->foreign('credito_disponivel_id')->references('id')->on('creditos_disponiveis');
            $table->unsignedBigInteger('unidade_administrativa_id');
            $table->foreign('unidade_administrativa_id')->references('id')->on('unidades_administrativas');
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
        Schema::dropIfExists('pessoas');
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('instituicoes');
        Schema::dropIfExists('exercicios');
        Schema::dropIfExists('unidades_gestoras');
        Schema::dropIfExists('unidades_administrativas');
        Schema::dropIfExists('grupos_fontes');
        Schema::dropIfExists('especificacoes');
        Schema::dropIfExists('fontes_tipos');
    }
}
