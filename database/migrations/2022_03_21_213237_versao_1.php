<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Versao1 extends Migration
{
    public function up()
    {
        // Tabela de Instituições
        Schema::create('instituicoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('sigla')->nullable();
            $table->string('cnpj');
            $table->string('ugr');
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
            $table->string('uasg');
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
            $table->string('matricula');
            $table->integer('titulacao');
            $table->string('password');
            $table->string('perfil')->default('basico'); // institucional | gestor | administrativo
            $table->tinyInteger('ativo')->default(0);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('users_vinculos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('instituicao_id')->nullable();
            $table->foreign('instituicao_id')->references('id')->on('instituicoes');
            $table->unsignedBigInteger('unidade_gestora_id')->nullable();
            $table->foreign('unidade_gestora_id')->references('id')->on('unidades_gestoras');
            $table->unsignedBigInteger('unidade_administrativa_id')->nullable();
            $table->foreign('unidade_administrativa_id')->references('id')->on('unidades_administrativas');
            $table->timestamps();
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
            $table->string('tipo_dado');
            $table->float('valor_inicial');
            $table->float('valor_final');
            $table->float('valor_atingido')->nullable();
            $table->unsignedBigInteger('objetivo_id');
            $table->foreign('objetivo_id')->references('id')->on('objetivos');
            $table->unsignedBigInteger('plano_acao_id');
            $table->foreign('plano_acao_id')->references('id')->on('planos_acoes');
            $table->timestamps();
        });

        Schema::create('metas_responsaveis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meta_id');
            $table->foreign('meta_id')->references('id')->on('metas');
            $table->unsignedBigInteger('unidade_gestora_id');
            $table->foreign('unidade_gestora_id')->references('id')->on('unidades_gestoras');
            $table->timestamps();
        });

        Schema::create('checkins', function (Blueprint $table) {
            $table->id();
            $table->float('valor');
            $table->longText('descricao');
            $table->unsignedBigInteger('meta_id');
            $table->foreign('meta_id')->references('id')->on('metas');
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
        // Tabela Ações Tipos
        Schema::create('acoes_tipos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('codigo');
            $table->string('nome_simplificado')->nullable();
            $table->tinyInteger('custeio')->default(0);
            $table->tinyInteger('investimento')->default(0);
            $table->tinyInteger('fav')->default(0);
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

        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->unsignedBigInteger('exercicio_id');
            $table->foreign('exercicio_id')->references('id')->on('exercicios');
            $table->timestamps();
        });

        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->unsignedBigInteger('agenda_id');
            $table->foreign('agenda_id')->references('id')->on('agendas');
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
    }
}
