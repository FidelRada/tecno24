<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Models\User;
//use App\Models\Cliente;

class Persona extends Model
{
    use HasFactory;
    protected $fillable = [
        'ci', 'nombre', 'apellidopaterno', 'apellidomaterno', 'sexo', 'telefono', 'direccion'
    ];

    public function cliente()
    {
        return $this->hasOne(Cliente::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function proveedor()
    {
        return $this->hasOne(Proveedor::class);
    }

    public function personal()
    {
        return $this->hasOne(Personal::class);
    }
}
