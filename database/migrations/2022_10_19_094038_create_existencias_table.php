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
        Schema::create('existencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_libro");
            $table->foreign('id_libro')->references('id')->on('libros');
            $table->unsignedBigInteger("id_sucursal");
            $table->foreign('id_sucursal')->references('id')->on('sucursales');
            $table->integer("existencias");
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
        Schema::dropIfExists('existencias');
    }
};
