<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MetaOrcamentaria;

class MetaOrcamentariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MetaOrcamentaria::create([
            'nome' => 'Meta Orçamentária 1',
            'qtd_estimada' => 100,
            'qtd_alcancada' => 50,
            'instituicao_id' => 1,
            'unidade_gestora_id' => 1,
            'exercicio_id' => 1,
            'acao_id' => 4
         ]);

        MetaOrcamentaria::create([
            'nome' => 'Meta Orçamentária 2',
            'acao_id' => 2,
            'natureza_despesa_id' => 111,
            'instituicao_id' => 1,
            'unidade_gestora_id' => 1,
            'exercicio_id' => 1
        ]);

        // MetaOrcamentaria::create([
        //     'nome' => 'Meta Orçamentária 3',
        //     'acao_id' => 1,
        //     'natureza_despesa_id' => 111,
        //     'instituicao_id' => 1,
        //     'unidade_gestora_id' => 1
        // ]);

        MetaOrcamentaria::create([
            'nome' => 'Meta Orçamentária 4',
            'acao_id' => 4,
            'natureza_despesa_id' => 103,
            'instituicao_id' => 1,
            'unidade_gestora_id' => 1,
            'exercicio_id' => 1
        ]);
    }
}
