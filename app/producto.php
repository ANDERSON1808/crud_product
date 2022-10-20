<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class producto extends Model
{
    protected $table = 'productos';
    protected $fillable =
    [
        'id',
        'referencia',
        'nombre_de_producto',
        'observaciones',
        'precio',
        'impuesto',
        'cantidad',
        'estado',
        'imagen'
    ];
}