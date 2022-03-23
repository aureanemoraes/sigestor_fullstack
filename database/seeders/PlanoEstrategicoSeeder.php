<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlanoEstrategico;

class PlanoEstrategicoSeeder extends Seeder
{
    public function run()
    {
        PlanoEstrategico::create([
            'nome' => 'Plano Estratégico 1',
            'data_inicio' => '2020-01-01',
            'data_fim' => '2025-12-31',
            'instituicao_id' => 1
        ]);
    }
}
