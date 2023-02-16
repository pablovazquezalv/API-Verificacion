<?php

namespace App\Models\Paqueteria;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Paqueteria\Repartidor;
use App\Models\Paqueteria\Vehiculo;
use App\Models\Paqueteria\Paquete;

class RepartidorVehiculoPaquete extends Model
{
    protected $table = 'repartidorvehiculopaquete';

    public function repartidor()
    {
        return $this->belongsToMany(Repartidor::class);
    }

    public function vehiculo()
    {
        return $this->belongsToMany(Vehiculo::class);
    }

    public function paquete()
    {
        return $this->belongsToMany(Paquete::class);
    }

    use HasFactory;
}
