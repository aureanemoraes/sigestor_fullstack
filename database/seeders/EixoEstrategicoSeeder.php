<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EixoEstrategico;

class EixoEstrategicoSeeder extends Seeder
{
    public function run()
    {
        EixoEstrategico::create([
            'nome' => 'Eixo Estratégico 1',
            'plano_estrategico_id' => 1,
        ]);

        EixoEstrategico::create([
            'nome' => 'Eixo Estratégico 2',
            'plano_estrategico_id' => 1,
        ]);
    }
}
