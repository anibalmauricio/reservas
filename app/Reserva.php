<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    
    protected $table = 'reservas';

    public function ubicaciones() {
        return $this->hasMany('App\UbicacionReserva', 'reserva_id', 'id');
    }
}
