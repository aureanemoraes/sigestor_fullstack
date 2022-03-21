<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Programa;

class ProgramaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Programa::create([ 'codigo' => '1061', 'nome' => 'Brasil Escolarizado', 'fav' => 1 ]);
        Programa::create([ 'codigo' => '1062', 'nome' => 'Desenvolvimento da Educação Profissional e Tecnológica' ]);
        Programa::create([ 'codigo' => '0089', 'nome' => 'Previdência de Inativos e Pensionistas da União' ]);
        Programa::create([ 'codigo' => '0750', 'nome' => 'Apoio Administrativo' ]);
        Programa::create([ 'codigo' => '0901', 'nome' => 'Cumprimento de Senteça Judicial Transitado em Julgado (Precatórios)' ]);
    }
}
