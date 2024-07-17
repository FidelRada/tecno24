<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombreempresa',
        'cargoempresa',
        'telefonoreferencia',
        'person_id',
    ];

    public function user()
    {
        return $this->belongsTo(Persona::class, 'person_id');
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'person_id');
    }
}
