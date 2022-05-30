<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'cpf',
        'matricula',
        'password',
        'perfil',
        'ativo',
        'titulacao',
        'remember_token'
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'unidades_gestoras',
        'unidades_administrativas'
    ];


    public function getUnidadesGestorasAttribute()
    {
        return $this->vinculos()->pluck('unidade_gestora_id')->toArray();
    }

    public function getUnidadesAdministrativasAttribute()
    {
        return $this->vinculos()->pluck('unidade_administrativa_id')->toArray();
    }

    public function vinculos()
    {
        return $this->hasMany(UserVinculo::class);
    }
}
