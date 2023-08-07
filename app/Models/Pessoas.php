<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pessoas extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'cpf',
        'email',
        'categoria'
    ];

    protected $casts = [
        'categoria' => 'integer',
    ];


    // realacionamento com Pedidos
    public function pedidos()
    {
        //
    }

}
