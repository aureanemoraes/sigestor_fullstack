<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ploa;

class PloaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 20RL - id: 1294
        Ploa::create([
            'exercicio_id' => 2,
            'programa_id' => 1,
            'fonte_tipo_id' => 1,
            'acao_tipo_id'=> 1294,
            'instituicao_id' => 1,
            'tipo_acao' => 'custeio',
            'valor' => 10000
        ]);

        Ploa::create([
            'exercicio_id' => 2,
            'programa_id' => 1,
            'fonte_tipo_id' => 1,
            'acao_tipo_id'=> 1294,
            'instituicao_id' => 1,
            'tipo_acao' => 'investimento',
            'valor' => 10000
        ]);

         // 2994 - id: 365
         Ploa::create([
            'exercicio_id' => 2,
            'programa_id' => 1,
            'fonte_tipo_id' => 1,
            'acao_tipo_id'=> 365,
            'instituicao_id' => 1,
            'tipo_acao' => 'custeio',
            'valor' => 10000
        ]);

        // 20RG - id: 2049
        Ploa::create([
            'exercicio_id' => 2,
            'programa_id' => 1,
            'fonte_tipo_id' => 1,
            'acao_tipo_id'=> 2049,
            'instituicao_id' => 1,
            'tipo_acao' => 'investimento',
            'valor' => 10000
        ]);

    }
}
