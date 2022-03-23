<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlanoAcao;

class PlanoAcaoSeeder extends Seeder
{
    public function run()
    {
        PlanoAcao::create([
            'nome' => 'Plano Ação 1',
            'data_inicio' => '2020-01-01',
            'data_fim' => '2020-12-31',
            'plano_estrategico_id' => 1,
            'instituicao_id' => 1
        ]);

        PlanoAcao::create([
            'nome' => 'Plano Ação 2',
            'data_inicio' => '2021-01-01',
            'data_fim' => '2021-12-31',
            'plano_estrategico_id' => 1,
            'instituicao_id' => 1
        ]);
    }
}
