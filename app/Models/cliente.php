<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cliente extends Model
{
    use HasFactory;
    protected $table = 'clientes';
    protected $fillable =['id','nombre','tipo_documento','num_documento','direccion','telefono','email','condicion'];
    public $timestamps =false;
}
