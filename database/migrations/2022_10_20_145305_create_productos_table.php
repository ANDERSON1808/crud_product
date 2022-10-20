<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('referencia')->unique();
            $table->string('nombre_de_producto');
            $table->string('observaciones');
            $table->float('precio', 10, 2);
            $table->float('impuesto', 5, 2);
            $table->bigInteger('cantidad');
            $table->enum('estado', ['activo', 'inactivo'])->default('activo')->nullable();
            $table->string('imagen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}