<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meta;
use Illuminate\Support\Str;

class MetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Meta::create([
            'nome' => 'Meta teste ' . Str::random(20),
            'descricao' => null, 
            'tipo' => 'porcentagem', // porcentagem, valor, maior_que, menor_que ,
            'tipo_dado' => 'numeral',
            'valor_inicial' => 0, //
            'valor_final' => 100, // 100%
            'valor_atingido' => 0, // 2%
            'objetivo_id' => 1,
            'plano_acao_id' => 1
        ]);
    }
}
