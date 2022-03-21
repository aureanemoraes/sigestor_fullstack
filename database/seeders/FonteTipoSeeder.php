<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FonteTipo;

class FonteTipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FonteTipo::create([
            'grupo_fonte_id' => 1,
            'especificacao_id' => 1,
            'nome' => 'Recursos Ordinários - Transferências do Imposto sobre a Renda e sobre Produtos Industrializados',
            'codigo' => null
        ]);
        FonteTipo::create([
            'grupo_fonte_id' => 1,
            'especificacao_id' => 0,
            'nome' => 'Recursos Ordinários - Recursos Ordinários',
            'codigo' => null
        ]);
    }
}
