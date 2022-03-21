<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nome' => 'Usuário Instituição Teste',
            'cpf' => '00607092270',
            'password' => Hash::make('12345678'),
            'perfil' => 'instituicao',
            'ativo' => 0,
            'instituicao_id' => 1,
            'unidade_gestora_id' => null,
            'unidade_administrativa_id' => null,
        ]);
    }
}
