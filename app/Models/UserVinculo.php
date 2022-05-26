<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVinculo extends Model
{
    use HasFactory;

    protected $table = 'users_vinculos';

    protected $fillable = [
        'user_id',
        'instituicao_id',
        'unidade_gestora_id',
        'unidade_administrativa_id'
    ];
}
