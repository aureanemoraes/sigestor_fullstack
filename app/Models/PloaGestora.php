<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PloaGestora extends Model
{
    use HasFactory;

    protected $table = 'ploas_gestoras';

    protected $fillable = [
        'ploa_id',
        'unidade_gestora_id',
        'valor'
    ];

    public function ploa()
    {
        return $this->belongsTo(Ploa::class);
    }

    public function ploa_administrativa()
    {
        return $this->hasOne(PloaAdministrativa::class);
    }

}
