<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleInsumo extends Model
{

    protected $fillable = [
    'cantidad',
    'id_insumo',
    'id_movimiento',
    ];


    public function insumo(){
        return $this->belongsTo(Insumo::class, 'id_insumo');
    }

    public function movimiento(){
        return $this->belongsTo(Movimiento::class, 'id_movimiento');
    }

    use HasFactory;
}
