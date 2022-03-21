<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GrupoFonte;

class GrupoFonteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GrupoFonte::create([ 'id' => '1', 'nome' => 'Recursos do Tesouro - Exercício Corrente' ]);
        GrupoFonte::create([ 'id' => '2', 'nome' => 'Recursos de Outras Fontes - Exercício Corrente' ]);
        GrupoFonte::create([ 'id' => '3', 'nome' => 'Recursos do Tesouro - Exercícios Anteriores' ]);
        GrupoFonte::create([ 'id' => '6', 'nome' => 'Recursos de Outras Fontes - Exercícios Anteriores' ]);
        GrupoFonte::create([ 'id' => '9', 'nome' => 'Recursos Condicionados' ]);
    }
}
