<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repartidorvehiculopaquete', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("repartidor_id");
            $table->unsignedBigInteger("vehiculo_id");
            $table->date("fecha");
            $table->unsignedBigInteger("paquete_id");
            $table->foreign('repartidor_id')->references('id')->on('repatidores');
            $table->foreign('vehiculo_id')->references('id')->on('vehiculos');
            $table->foreign('paquete_id')->references('id')->on('paquetes');
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
        Schema::dropIfExists('repartidorvehiculopaquete');
    }
};
