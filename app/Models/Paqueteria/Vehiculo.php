<?php

namespace App\Models\Paqueteria;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Paqueteria\RepartidorVehiculoPaquete;

class Vehiculo extends Model
{
    use HasFactory;

    protected $table = 'vehiculos';

    public function vehiculos()
    {
        return $this->belongsTo(Vehiculos::class);
    }
    

    public function repartidorVehiculoPaquete()
    {
        return $this->belongsToMany(RepartidorVehiculoPaquete::class);
    }
}
