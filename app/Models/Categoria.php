<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    // use HasFactory;
    // use HasFactory;

    protected $table = 'categoria';
    // protected $primarykey='id';
    protected $fillable = ['nombre', 'descripcion', 'condicion'];

    // relacion uno a muchos
    public function articulos()
    {
        return $this->hasMany(Articulo::class);
    }
}
