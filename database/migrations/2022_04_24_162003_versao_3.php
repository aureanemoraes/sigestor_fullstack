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

        Schema::create('creditos_planejados', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_processo');
            $table->float('valor_solicitado');
            $table->longText('comentarios')->nullable();
            $table->string('unidade_gestora')->default('pendente'); // pendente; deferido; indeferido
            $table->string('instituicao')->default('pendente'); //  pendente; deferido; indeferido
            $table->tinyInteger('solicitado')->default(1);
            $table->unsignedBigInteger('despesa_id');
            $table->foreign('despesa_id')->references('id')->on('despesas');
            $table->timestamps();
        });

        Schema::create('certidoes_creditos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_certidao');
            $table->unsignedBigInteger('credito_planejado_id');
            $table->foreign('credito_planejado_id')->references('id')->on('creditos_planejados');
            $table->timestamps();
        });
        Schema::create('empenhos', function (Blueprint $table) {
            $table->id();
            $table->json('notas_fiscais');
            $table->unsignedBigInteger('certidao_credito_id');
            $table->foreign('certidao_credito_id')->references('id')->on('certidoes_creditos');
            $table->timestamps();
        });
        Schema::create('remanejamentos', function (Blueprint $table) {
            $table->id();
            $table->float('valor');
            $table->float('numero_oficio');
            $table->date('data');
            $table->unsignedBigInteger('despesa_remetente_id');
            $table->foreign('despesa_remetente_id')->references('id')->on('despesas');
            $table->unsignedBigInteger('despesa_destinatario_id');
            $table->foreign('despesa_destinatario_id')->references('id')->on('despesas');
            $table->timestamps();
        });
    }

    public function down()
    {
        //
    }
}
