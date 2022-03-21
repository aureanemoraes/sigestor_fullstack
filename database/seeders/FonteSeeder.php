<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fonte;

class FonteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Fonte::create([
            'fonte_tipo_id' => 1,
            'exercicio_id' => 1,
            'instituicao_id' => 1,
            'valor' => 10000,
            'fav' => 1
        ]);

        Fonte::create([
            'fonte_tipo_id' => 2,
            'exercicio_id' => 1,
            'instituicao_id' => 1,
            'valor' => 30000
        ]);

        Fonte::create([
            'fonte_tipo_id' => 2,
            'exercicio_id' => 1,
            'instituicao_id' => 1,
            'valor' => 15000
        ]);
    }
}
