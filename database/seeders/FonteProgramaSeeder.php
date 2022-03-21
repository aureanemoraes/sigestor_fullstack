<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FontePrograma;

class FonteProgramaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FontePrograma::create(['fonte_id' => 1, 'programa_id' => 1, 'exercicio_id' => 1]);
        FontePrograma::create(['fonte_id' => 1, 'programa_id' => 2, 'exercicio_id' => 1]);
    }
}
