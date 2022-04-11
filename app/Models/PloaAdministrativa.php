<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PloaAdministrativa extends Model
{
    use HasFactory;

    protected $table = 'ploas_administrativas';

    protected $fillable = [
        'ploa_gestora_id',
        'unidade_administrativa_id',
        'valor'
    ];

    public function ploa_gestora()
    {
        return $this->belongsTo(PloaGestora::class);
    }

    public function despesas()
    {
        return $this->hasMany(Despesa::class);
    }
}
