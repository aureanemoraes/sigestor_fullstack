<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserVinculo;

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
            'matricula' => '123456',
            'titulacao' => 1,
            'password' => Hash::make('12345678'),
            'perfil' => 'institucional',
            'ativo' => 0
        ]);

        UserVinculo::create([
            'user_id' => 1,
            'instituicao_id' => 1
        ]);
    }
}
