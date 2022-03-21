<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FonteAcao;

class FonteAcaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fonte 1: 10000
        // Instituicões
        FonteAcao::create([
            'fonte_id' => 1,
            'acao_id' => 1,
            'exercicio_id' => 1,
            'valor' => 5000,
            'instituicao_id' => 1
        ]);
        FonteAcao::create([
            'fonte_id' => 1,
            'acao_id' => 2,
            'exercicio_id' => 1,
            'valor' => 5000,
            'instituicao_id' => 1
        ]);
        // Unidades Gestoras
        FonteAcao::create([
            'fonte_id' => 1,
            'acao_id' => 1,
            'exercicio_id' => 1,
            'valor' => 2500,
            'unidade_gestora_id' => 1
        ]);
        FonteAcao::create([
            'fonte_id' => 1,
            'acao_id' => 2,
            'exercicio_id' => 1,
            'valor' => 2500,
            'unidade_gestora_id' => 1
        ]);
        // Unidades Administrativas
        FonteAcao::create([
            'fonte_id' => 1,
            'acao_id' => 4,
            'exercicio_id' => 1,
            'valor' => 2500,
            'unidade_administrativa_id' => 1
        ]);
        FonteAcao::create([
            'fonte_id' => 1,
            'acao_id' => 2,
            'exercicio_id' => 1,
            'valor' => 1000,
            'unidade_administrativa_id' => 1
        ]);

        // Fonte 2: 30000
        // Instituicoes
        FonteAcao::create([
            'fonte_id' => 2,
            'acao_id' => 1,
            'exercicio_id' => 1,
            'valor' => 10000,
            'instituicao_id' => 1
        ]);
        FonteAcao::create([
            'fonte_id' => 2,
            'acao_id' => 2,
            'exercicio_id' => 1,
            'valor' => 10000,
            'instituicao_id' => 1
        ]);
        FonteAcao::create([
            'fonte_id' => 2,
            'acao_id' => 3,
            'exercicio_id' => 1,
            'valor' => 10000,
            'instituicao_id' => 1
        ]);
        // Unidades Gestoras
        FonteAcao::create([
            'fonte_id' => 2,
            'acao_id' => 1,
            'exercicio_id' => 1,
            'valor' => 2500,
            'unidade_gestora_id' => 1
        ]);
        FonteAcao::create([
            'fonte_id' => 2,
            'acao_id' => 2,
            'exercicio_id' => 1,
            'valor' => 2500,
            'unidade_gestora_id' => 1
        ]);
        // Unidades Administrativas
        FonteAcao::create([
            'fonte_id' => 2,
            'acao_id' => 4,
            'exercicio_id' => 1,
            'valor' => 2500,
            'unidade_administrativa_id' => 1
        ]);
        FonteAcao::create([
            'fonte_id' => 2,
            'acao_id' => 2,
            'exercicio_id' => 1,
            'valor' => 2000,
            'unidade_administrativa_id' => 1
        ]);

        // FONTE 3
        FonteAcao::create([
            'fonte_id' => 3,
            'acao_id' => 1,
            'exercicio_id' => 1,
            'valor' => 5000,
            'instituicao_id' => 1
        ]);
        FonteAcao::create([
            'fonte_id' => 3,
            'acao_id' => 2,
            'exercicio_id' => 1,
            'valor' => 5000,
            'instituicao_id' => 1
        ]);
        // Unidades Gestoras
        FonteAcao::create([
            'fonte_id' => 3,
            'acao_id' => 1,
            'exercicio_id' => 1,
            'valor' => 2500,
            'unidade_gestora_id' => 1
        ]);
        FonteAcao::create([
            'fonte_id' => 3,
            'acao_id' => 2,
            'exercicio_id' => 1,
            'valor' => 2500,
            'unidade_gestora_id' => 1
        ]);
        // Unidades Administrativas
        FonteAcao::create([
            'fonte_id' => 3,
            'acao_id' => 4,
            'exercicio_id' => 1,
            'valor' => 2500,
            'unidade_administrativa_id' => 2
        ]);
        FonteAcao::create([
            'fonte_id' => 3,
            'acao_id' => 2,
            'exercicio_id' => 1,
            'valor' => 1000,
            'unidade_administrativa_id' => 2
        ]);
    }
}
