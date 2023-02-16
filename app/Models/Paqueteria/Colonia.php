<?php

namespace App\Models\Paqueteria;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Paqueteria\Ciudad;
use App\Models\Paqueteria\Paquete;

class Colonia extends Model
{
    protected $table = 'colonias';

    use HasFactory;

    public function colonias()
    {
        return $this->belongsTo(Ciudad::class);
    }
    
    public function paquete()
    {
        return $this->hasMany(Paquete::class);
    }
    
}
