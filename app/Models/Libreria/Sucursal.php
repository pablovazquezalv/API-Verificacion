<?php

namespace App\Models\Libreria;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\libreria\Existencia;

class Sucursal extends Model
{
    use HasFactory;

    protected $table = "sucursal";

    public function existencia()
    {
        return $this->belongsTo(Existencia::class);
    }
}
