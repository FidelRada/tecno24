<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cliente_id', 'descripciongeneral', 'fechaEntrega', 'estado'
    ];

    /**
     * Get the detalles for the pedido.
     */
    public function detallepedido()
    {
        return $this->hasMany(DetallePedido::class);
    }

    /**
     * Get the cliente that owns the pedido.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
