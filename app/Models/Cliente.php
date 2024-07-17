<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Models\Persona;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nit', 'person_id'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'person_id');
    }
}
