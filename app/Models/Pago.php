<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   protected $fillable = [
       'pedido_id', 'fechapago', 'horapago', 'estado', 'metodopago'
   ];

   /**
    * Get the detalles for the pedido.
    */
   /**
    * Get the cliente that owns the pedido.
    */
   public function pedido()
   {
       return $this->belongsTo(Pedido::class);
   }
}
