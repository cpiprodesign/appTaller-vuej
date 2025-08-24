<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = 'documento';  // si tu tabla se llama exactamente 'documento'
    protected $fillable = ['id', 'short', 'nombre', 'numero', 'condicion'];  // agrega los campos que vas a usar
    // use HasFactory;
}
