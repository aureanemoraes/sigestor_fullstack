<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exercicio;

class ExercicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Exercicio::create([
            'nome' => '2020',
            'data_inicio' => '2019-03-01',
            'data_fim' => '2019-12-31',
            'instituicao_id' => 1
        ]);

        Exercicio::create([
            'nome' => '2023',
            'data_inicio' => '2022-03-01',
            'data_fim' => '2022-12-31',
            'instituicao_id' => 1
        ]);
    }
}
