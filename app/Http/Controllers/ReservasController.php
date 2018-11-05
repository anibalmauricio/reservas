<?php

namespace App\Http\Controllers;

use App\Reserva;
use App\UbicacionReserva;
use Illuminate\Http\Request;

class ReservasController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reservas');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reserva = Reserva::find($id);
        $ubicaciones = UbicacionReserva::where('reserva_id', $id)->get();

        $reserva = $reserva->toArray();
        $reserva['books'] = $ubicaciones->toArray();
        $reserva = json_encode($reserva);
        return View('reserva', compact('reserva'));
    }

    public function new()
    {
        // $reserva = Reserva::find($id);
        // echo "<pre>";
        // print_r($reserva);
        // echo "</pre>";
        return View('reserva');
    }

    /**
     * Verificamos disponibilidad de ubicación
     *
     * @param  date  $fecha
     * @param  int  $row
     * @param  int  $col
     * @return array
     */
    public function disponibilidad($fecha, $row, $col)
    {
        $ubicacion = ['row' => $row, 'col' => $col];

        $reservas = Reserva::where('fecha_reserva', $fecha)->get();
        $is_available = 0;
        foreach ($reservas as $reserva) {
            $is_available = Reserva::find($reserva->id)->ubicaciones()->where($ubicacion)->count();
            if ($is_available > 0) {
                break;
            }
        }

        $array = array('disponibilidad' => $is_available);
        $array = json_encode($array);
        return $array;
    }

}
