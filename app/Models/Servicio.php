<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $fillable = [
        'descripcion', 'url'
    ];

    /**
     * Obtener los detalles de pedido asociados a este servicio.
     */
    public function detallesPedido()
    {
        return $this->hasMany(DetallePedido::class);
    }
    
    public function diseño()
    {
        return $this->hasOne(Diseño::class);
    }

    public function impresion()
    {
        return $this->hasOne(Impresion::class);
    }

    public function arquitectura()
    {
        return $this->hasOne(Arquitectura::class);
    }

    public function bastidor()
    {
        return $this->hasOne(Bastidor::class);
    }

    public function acondicionamiento()
    {
        return $this->hasOne(Acondicionamiento::class);
    }
    
}
