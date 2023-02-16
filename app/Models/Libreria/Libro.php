<?php

namespace App\Models\Libreria;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\libreria\Editorial;

class Libro extends Model
{
    use HasFactory;

    protected $table = "libros";

    public function editoriales()
    {
        return $this->belongsTo(Editorial::class);
    }
}
