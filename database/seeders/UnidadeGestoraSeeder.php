<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UnidadeGestora;

class UnidadeGestoraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UnidadeGestora::create([
            'nome' => 'Unidade Gestora 1',
            'sigla' => 'UG1',
            'cnpj' => '54864165000130',
            'uasg' => 'uasg',
            'logradouro' => 'av. logradouro',
            'numero' => '1212',
            'bairro' => 'bairro',
            'complemento' => 'complemento',
            'instituicao_id' => 1
        ]);

        UnidadeGestora::create([
            'nome' => 'Unidade Gestora 2',
            'sigla' => 'UG2',
            'cnpj' => '54864265000230',
            'uasg' => 'uasg',
            'logradouro' => 'av. logradouro',
            'numero' => '2222',
            'bairro' => 'bairro',
            'complemento' => 'complemento',
            'instituicao_id' => 1
        ]);
    }
}
