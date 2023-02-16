<?php

namespace App\Models\Paqueteria;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Paqueteria\Estado;
use App\Models\Paqueteria\Colonia;

class Ciudad extends Model
{
    use HasFactory;

    protected $table = 'ciudades';

    public function ciudades()
    {
        return $this->belongsTo(Estado::class);
    }


    public function colonia()
    {
        return $this->hasMany(Colonia::class);
    }

    
}
