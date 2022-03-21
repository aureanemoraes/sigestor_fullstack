<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Instituicao;

class InstituicaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Instituicao::create(['nome' => 'Instituição 1', 'sigla' => 'IT1', 'cnpj' => '18063217000106', 'uasg' => 'uasg', 'logradouro' => 'av. logradouro', 'numero' => '11', 'bairro' => 'bairro', 'complemento' => 'complemento' ]);

        Instituicao::create(['nome' => 'Instituição 2', 'sigla' => 'IT2', 'cnpj' => '28063227000206', 'uasg' => 'uasg', 'logradouro' => 'av. logradouro', 'numero' => '21', 'bairro' => 'bairro', 'complemento' => 'complemento' ]);
    }
}
