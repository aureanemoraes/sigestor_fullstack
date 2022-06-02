<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PloaAdministrativa;

class PloaAdministrativaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 // 20RL - id: 1294
        PloaAdministrativa::create([
            'ploa_gestora_id' => 1, // custeio
            'unidade_administrativa_id' => 1,
            'valor' => 250
        ]);

        PloaAdministrativa::create([
            'ploa_gestora_id' => 1, // custeio
            'unidade_administrativa_id' => 2,
            'valor' => 250
        ]);

         // 2994 - id: 365
        PloaAdministrativa::create([
            'ploa_gestora_id' => 5, // investimento
            'unidade_administrativa_id' => 1,
            'valor' => 250
        ]);

        PloaAdministrativa::create([
            'ploa_gestora_id' => 5, // investimento
            'unidade_administrativa_id' => 2,
            'valor' => 250
        ]);

        // 20RG - id: 2049
        PloaAdministrativa::create([
            'ploa_gestora_id' => 7, // custeio
            'unidade_administrativa_id' => 1,
            'valor' => 250
        ]);

        PloaAdministrativa::create([
            'ploa_gestora_id' => 7, // custeio
            'unidade_administrativa_id' => 2,
            'valor' => 250
        ]);
    }
}
