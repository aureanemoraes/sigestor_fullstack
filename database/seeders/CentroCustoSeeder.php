<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CentroCusto;

class CentroCustoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CentroCusto::create([
            'nome' => 'Centro de Custo 1'
        ]);

        CentroCusto::create([
            'nome' => 'Centro de Custo 2'
        ]);
    }
}
