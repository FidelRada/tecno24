<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Insumo extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['nombre', 'marca', 'origen', 'categoria_insumo_id'];

    public function categoriainsumo(){
        return $this->belongsTo(CategoriaInsumo::class, 'categoria_insumo_id');
    }

    public function toSearchableArray()
    {
        return [
            'nombre' => $this->nombre,
            'marca' => $this->marca,
            'origen' => $this->origen,
            
            // otros campos
        ];
    }

    public function getTypeAndContent()
    {
        return 'Insumo: ' . $this->nombre . ' | marca: ' . $this->marca . ' | origen ' . $this->origen; // Ajusta esto según el campo que desees mostrar
    }

}
