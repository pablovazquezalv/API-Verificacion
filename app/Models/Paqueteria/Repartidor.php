<?php

namespace App\Models\Paqueteria;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Paqueteria\RepartidorVehiculoPaquete;

class Repartidor extends Model
{
    use HasFactory;

    protected $table = 'repatidores';


    public function repartidores()
    {
        return $this->belongsTo(Repartidores::class);
    }

    public function repartidorVehiculoPaquete()
    {
        return $this->belongsToMany(RepartidorVehiculoPaquete::class);
    }


}
