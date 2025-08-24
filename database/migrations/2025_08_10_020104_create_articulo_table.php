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
        Schema::create('articulo', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('idcategoria')->unsigned();
            $table->Integer('idmarca')->unsigned();
            $table->Integer('idproveedor')->unsigned();
            $table->string('codigo', 50)->nullable();
            $table->string('nombre', 100)->unique();
            $table->decimal('precio_venta', 11, 2);
            $table->decimal('precio_compra', 11, 2);
            $table->decimal('precio_base', 11, 6);
            $table->integer('stock');
            $table->datetime('vencimiento');
            $table->string('imagen');
            $table->string('descripcion', 256)->nullable();
            $table->boolean('condicion')->default(1);
            $table->timestamps();
            // relacionar articulos con la tabla categorias
            $table->foreign('idcategoria')->references('id')->on('categoria');
            // relacionar articulos con la tabla marca
            $table->foreign('idmarca')->references('id')->on('marcas');
            // relacionar articulos con la tabla uvidad de proveedor
            $table->foreign('idproveedor')->references('id')->on('proveedor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articulo');
    }
};
