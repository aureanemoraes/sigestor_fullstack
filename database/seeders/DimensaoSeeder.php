<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dimensao;

class DimensaoSeeder extends Seeder
{
    public function run()
    {
        Dimensao::create([
            'nome' => 'Dimensão 1',
            'eixo_estrategico_id' => 1
        ]);
        Dimensao::create([
            'nome' => 'Dimensão 2',
            'eixo_estrategico_id' => 2
        ]);
    }
}
