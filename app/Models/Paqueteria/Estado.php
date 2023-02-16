<?php

namespace App\Models\Paqueteria;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Paqueteria\Ciudad;

class Estado extends Model
{
    use HasFactory;

    protected $table = 'estados';

    public function ciudad()
    {
        return $this->hasMany(Ciudad::class);
    }
}
