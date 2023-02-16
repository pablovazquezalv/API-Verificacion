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
        Schema::create('paquetes', function (Blueprint $table) {
            $table->id();
            $table->string("descripcion",50);
            $table->string("remitente",50);
            $table->string("tamaño",30);
            $table->string("peso",10);
            $table->string("dirreccion",100);
            $table->unsignedBigInteger("colonia_id");
            $table->foreign('colonia_id')->references('id')->on('colonias');
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
        Schema::dropIfExists('paquetes');
    }
};
