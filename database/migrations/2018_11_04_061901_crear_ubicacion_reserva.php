<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearUbicacionReserva extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ubicacion_reserva', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reserva_id')->unsigned();
            $table->foreign('reserva_id')->references('id')->on('reservas');
            $table->integer('fila')->unsigned();
            $table->integer('columna')->unsigned();
            $table->timestamps();
            $table->index(['reserva_id', 'fila', 'columna']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ubicacion_reserva');
    }
}
