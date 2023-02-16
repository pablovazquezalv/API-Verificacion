<?php

namespace App\Models\Libreria;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\libreria\Libro;
use App\Models\libreria\Sucursal;
class Existencia extends Model
{
    use HasFactory;

    protected $table = "existencias";

    public function libros()
    {
        return $this->belongsTo(Libro::class);
    }
    public function sucursales()
    {
        return $this->belongsTo(Sucursal::class);
    }
}
