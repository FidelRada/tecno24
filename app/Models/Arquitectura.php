<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arquitectura extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */    
    protected $fillable = [
        'formato', 'servicio_id',
    ];

    

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}
