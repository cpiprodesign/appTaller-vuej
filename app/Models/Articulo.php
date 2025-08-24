<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $table = 'articulo';

    protected $fillable = [
        'idcategoria', 'idmarca', 'idUnidad', 'idproveedor', 'codigo', 'nombre', 'precio_venta', 'precio_compra', 'stock',
        'vencimiento', 'imagen', 'descripcion', 'condicion'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    /* public function kardex()
     {
         return $this->hasMany(Kardex::class);
     }*/
}
