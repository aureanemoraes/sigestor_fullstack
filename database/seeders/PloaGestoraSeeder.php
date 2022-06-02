<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PloaGestora;

class PloaGestoraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 20RL - id: 1294 - custeio e investimento
        PloaGestora::create([
            'ploa_id' => 1, // custeio
            'unidade_gestora_id' => 1,
            'valor' => 500
        ]);

        PloaGestora::create([
            'ploa_id' => 2, // investimento
            'unidade_gestora_id' => 1,
            'valor' => 500
        ]);

        PloaGestora::create([
            'ploa_id' => 1, // custeio
            'unidade_gestora_id' => 2,
            'valor' => 500
        ]);

        PloaGestora::create([
            'ploa_id' => 2, // investimento
            'unidade_gestora_id' => 2,
            'valor' => 500
        ]);

         // 2994 - id: 365 = custeio
        PloaGestora::create([
            'ploa_id' => 3,
            'unidade_gestora_id' => 1,
            'valor' => 500
        ]);

        PloaGestora::create([
            'ploa_id' => 3,
            'unidade_gestora_id' => 2,
            'valor' => 500
        ]);

        // 20RG - id: 2049 = investimento
        PloaGestora::create([
            'ploa_id' => 4,
            'unidade_gestora_id' => 1,
            'valor' => 500
        ]);

        PloaGestora::create([
            'ploa_id' => 4,
            'unidade_gestora_id' => 2,
            'valor' => 500
        ]);
    }
}
