<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Movimiento extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        "motivo",
        "fecha",
        "id_tipo",
        "id_personal",
        "id_proveedor",
    ];

    public function tipoMovimiento()
    {
        return $this->belongsTo(TipoMovimiento::class, "id_tipo");
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, "id_proveedor");
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class, "id_personal");
    }


    public function movimiento()
    {
        return $this->hasMany(Movimiento::class);
    }

    //PARA BUSCAQUEDAS
    public function toSearchableArray()
    {
        return [
            'motivo' => $this->motivo,
            'id_personal' => $this->id_personal,
            // otros campos
        ];
    }


    public function getTypeAndContent()
    {
        return 'Movimiento: | motivo: ' . $this->motivo; // Ajusta esto según el campo que desees mostrar
    }


}
