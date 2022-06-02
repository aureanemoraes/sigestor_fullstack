<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Despesa;
use Illuminate\Support\Str;

class DespesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 20RL - id: 1 (custeio),2 (investimento)
        // 103	"Diárias - Civil"
        Despesa::create([
            'descricao' => 'DESPESA TESTE ' . Str::random(20),
            'valor' => 20,
            'valor_total' => 20,
            'tipo' => 'despesa_variavel',
            'ploa_administrativa_id' => 1,
            'centro_custo_id' => 1,
            'natureza_despesa_id' => 103,
            'subnatureza_despesa_id' => null,
            'meta_id' => 1,
            'fields'  => null,
            'despesa_modelo_id' => null
        ]);
        
        Despesa::create([
            'descricao' => 'DESPESA TESTE ' . Str::random(20),
            'valor' => 10,
            'valor_total' => 10,
            'tipo' => 'despesa_fixa',
            'ploa_administrativa_id' => 1,
            'centro_custo_id' => 1,
            'natureza_despesa_id' => 103,
            'subnatureza_despesa_id' => null,
            'meta_id' => 1,
            'fields'  => null,
            'despesa_modelo_id' => null
        ]);

        // 111	"Material de Consumo"
        Despesa::create([
            'descricao' => 'DESPESA TESTE ' . Str::random(20),
            'valor' => 13,
            'valor_total' => 13,
            'tipo' => 'despesa_fixa',
            'ploa_administrativa_id' => 1,
            'centro_custo_id' => 1,
            'natureza_despesa_id' => null,
            'subnatureza_despesa_id' => 34,
            'meta_id' => 1,
            'fields'  => null,
            'despesa_modelo_id' => null
        ]);

        // 192	"Obras e Instalações"
        Despesa::create([
            'descricao' => 'DESPESA TESTE ' . Str::random(20),
            'valor' => 20,
            'valor_total' => 20,
            'tipo' => 'despesa_fixa',
            'ploa_administrativa_id' => 3,
            'centro_custo_id' => 1,
            'natureza_despesa_id' => 192,
            'subnatureza_despesa_id' => null,
            'meta_id' => 1,
            'fields'  => null,
            'despesa_modelo_id' => null
        ]);

        // 2994 - id: 365
        // 105	"Auxílio Financeiro a Estudantes" - Custeio
        Despesa::create([
            'descricao' => 'DESPESA TESTE ' . Str::random(20),
            'valor' => 50,
            'valor_total' => 50,
            'tipo' => 'despesa_fixa',
            'ploa_administrativa_id' => 5,
            'centro_custo_id' => 1,
            'natureza_despesa_id' => 105,
            'subnatureza_despesa_id' => null,
            'meta_id' => 1,
            'fields'  => null,
            'despesa_modelo_id' => null
        ]);
    }
}
