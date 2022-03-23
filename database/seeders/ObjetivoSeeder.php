<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Objetivo;

class ObjetivoSeeder extends Seeder
{
    public function run()
    {
        Objetivo::create([
            'nome' => 'Objetivo 1',
            'ativo' => 1,
            'dimensao_id' => 1
        ]);

        Objetivo::create([
            'nome' => 'Objetivo 2',
            'ativo' => 1,
            'dimensao_id' => 1
        ]);

        Objetivo::create([
            'nome' => 'Objetivo 3',
            'ativo' => 1,
            'dimensao_id' => 2
        ]);

        Objetivo::create([
            'nome' => 'Objetivo 4',
            'ativo' => 0,
            'dimensao_id' => 2
        ]);
    }
}
