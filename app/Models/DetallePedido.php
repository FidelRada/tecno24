<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pedido_id', 'servicio_id', 
    ];

    /**
     * Get the pedido that owns the detalle pedido.
     */
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}
