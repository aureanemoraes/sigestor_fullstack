<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UnidadeAdministrativa;

class UnidadeAdministrativaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UnidadeAdministrativa::create([
            'nome' => 'Unidade Administrativa 1',
            'sigla' => 'UA1',
            'ugr' => '123456',
            'instituicao_id' => 1,
            'unidade_gestora_id' => 1
        ]);
        UnidadeAdministrativa::create([
            'nome' => 'Unidade Administrativa 2',
            'sigla' => 'UA2',
            'ugr' => '223456',
            'instituicao_id' => 1,
            'unidade_gestora_id' => 1
        ]);
    }
}
