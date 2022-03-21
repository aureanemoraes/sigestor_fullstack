<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objetivo extends Model
{
    use HasFactory;

    protected $table = 'objetivos';

    protected $fillable = [
        'nome',
        'ativo',
        'dimensao_id'
    ];

    protected $appends = ['porcentagem_atual'];

    public function getPorcentagemAtualAttribute()
    {
        if(count($this->metas) > 0) {
            $porcentagem_atual = ($this->metas->sum('porcentagem_atual') * 100)/(100 * count($this->metas));
            return $porcentagem_atual;
        } else
            return null;
    }

    public function dimensao()
    {
        return $this->belongsTo(Dimensao::class);
    } 

    public function metas()
    {
        return $this->hasMany(Meta::class);
    } 
}
