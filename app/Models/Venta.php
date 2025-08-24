<?php

namespace App\Models;

use App\Models\Cliente;
use App\Models\DetalleVenta;
use App\Models\Documento;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = [
        'idcliente',
        'idusuario',
        'id_documento',
        'tipo_comprobante',
        'serie_comprobante',
        'num_comprobante',
        'fecha_hora',
        'impuesto',
        'total',
        'estado',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'idcliente');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'idventa');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'idusuario');
    }

    // relacion con tabla documentos
    public function documento()
    {
        return $this->belongsTo(Documento::class, 'id_documento');
    }
}
