<?php

namespace App\Models\Paqueteria;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Paqueteria\Colonia;
use App\Models\Paqueteria\RepartidorVehiculoPaquete;

class Paquete extends Model
{

    protected $table = 'paquetes';


    
    public function paquete()
    {
        return $this->belongsTo(Colonia::class);
    }

    public function repartidorVehiculoPaquete()
    {
        return $this->belongsToMany(RepartidorVehiculoPaquete::class);
    }

    use HasFactory;
}
