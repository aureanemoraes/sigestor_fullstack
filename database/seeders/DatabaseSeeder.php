<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            GrupoFonteSeeder::class,
            EspecificacaoSeeder::class,
            AcaoTipoSeeder::class,
            NaturezaDespesaSeeder::class,
            SubnaturezaDespesaSeeder::class,
            ProgramaSeeder::class,
            InstituicaoSeeder::class,
            UnidadeGestoraSeeder::class,
            CentroCustoSeeder::class,
            ExercicioSeeder::class,
            FonteTipoSeeder::class,
            UnidadeAdministrativaSeeder::class,
            FonteSeeder::class,
            AcaoSeeder::class,
            FonteAcaoSeeder::class,
            MetaOrcamentariaSeeder::class,
            DespesaSeeder::class,
            FonteProgramaSeeder::class,
            UserSeeder::class
        ]);
    }
}
