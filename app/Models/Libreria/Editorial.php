<?php

namespace App\Models\Libreria;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\libreria\Libro;

class Editorial extends Model
{
    use HasFactory;

    protected $table = "editoriales";

    public function libros()
    {
        return $this->belongsTo(libro::class);
    }
}
