<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    // use HasFactory;

    protected $table = 'marcas';
    // protected $primarykey='id';
    protected $fillable = ['nombre', 'descripcion', 'condicion'];

    // relacion uno a muchos
    public function articulos()
    {
        return $this->hasMany(Articulo::class);
    }
}
