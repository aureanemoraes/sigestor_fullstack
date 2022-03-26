<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';

    protected $fillable = [
        'nome',
        'data_inicio',
        'data_fim',
        'agenda_id'
    ];

    protected $appends = ['status'];


    public function getStatusAttribute($value)
    {
        // if(empty($value))
        //     $this->attributes['status'] = 'aberta';
        // else {
        //     if($this->data_fim <= date('Y-m-d'))
        //         $this->attributes['status'] = 'aberta';
        // }
    }


    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }
}
