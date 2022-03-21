<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Acao;

class AcaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Acao::create([
            'acao_tipo_id' => 1295,
            'exercicio_id' => 1,
            'instituicao_id' => 1,
            'fav' => 1 
        ]);

        Acao::create([
            'acao_tipo_id' => 365,
            'instituicao_id' => 1,
            'exercicio_id' => 1
        ]);

        Acao::create([
            'acao_tipo_id' => 2049,
            'exercicio_id' => 1,
            'instituicao_id' => 1,
            'fav' => 1 
        ]);

        // 1294 - Ação 20RL
        Acao::create([
            'acao_tipo_id' => 1294,
            'exercicio_id' => 1,
            'instituicao_id' => 1,
            'fav' => 1 
        ]);
    }
}
