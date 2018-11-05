<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UbicacionReserva extends Model
{
    protected $table = 'ubicacion_reserva';

    public function reserva()
    {
        return $this->belongsTo('App\Reserva');
    }
}
