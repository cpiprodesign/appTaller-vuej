<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';
    protected $fillable = ['id', 'nombre', 'tipo_documento', 'num_documento', 'direccion', 'telefono', 'email', 'condicion'];
    public $timestamps = false;

    public function orden()
    {
        return $this->hasMany(Orden::class);
    }

    // relacion con tabla proveedor

    /*public function proveedor()
    {
        return $this->hasOne('App\Models\Proveedor');
    }*/
    /* public function user()
     {
         return $this->hasOne('App\Models\User');
     }*/

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'idcliente');
    }

    public function documento()
    {
        return $this->belongsTo(tipo_documento_identidad::class);
    }
}
