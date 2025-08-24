<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documento', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('short')->nullable();
            $table->string('nombre', 50);
            $table->string('numero', 256);
            // $table->string('simbolo', 256);
            $table->boolean('condicion')->default(1);
            $table->timestamps();
        });
        DB::table('documento')->insert([
            ['numero' => '01', 'condicion' => true, 'short' => 'FT', 'nombre' => 'FACTURA ELECTRÓNICA'],
            ['numero' => '03', 'condicion' => true, 'short' => 'BV', 'nombre' => 'BOLETA DE VENTA ELECTRÓNICA'],
            ['numero' => '07', 'condicion' => true, 'short' => 'NC', 'nombre' => 'NOTA DE CRÉDITO'],
            ['numero' => '08', 'condicion' => true, 'short' => 'ND', 'nombre' => 'NOTA DE DÉBITO'],
            ['numero' => '09', 'condicion' => true, 'short' => null, 'nombre' => 'GUIA DE REMISIÓN REMITENTE'],
            ['numero' => '20', 'condicion' => true, 'short' => null, 'nombre' => 'COMPROBANTE DE RETENCIÓN ELECTRÓNICA'],
            ['numero' => '31', 'condicion' => true, 'short' => null, 'nombre' => 'Guía de remisión transportista'],
            ['numero' => '40', 'condicion' => true, 'short' => null, 'nombre' => 'COMPROBANTE DE PERCEPCIÓN ELECTRÓNICA'],
            ['numero' => '71', 'condicion' => false, 'short' => null, 'nombre' => 'Guia de remisión remitente complementaria'],
            ['numero' => '72', 'condicion' => false, 'short' => null, 'nombre' => 'Guia de remisión transportista complementaria'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documento');
    }
};
