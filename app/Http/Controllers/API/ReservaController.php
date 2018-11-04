<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Reserva;
use App\UbicacionReserva;

class ReservaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Reserva::where('user_id', auth()->id())->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reserva = new Reserva();
        $reserva->fecha_reserva = $request->fecha_reserva;
        $reserva->personas = $request->personas;
        $reserva->user_id = auth()->id();
        $reserva->save();

        // Submitted books
        $books = $request->books;

        $this->store_ubications($books, $reserva->id);

        return $reserva;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $reserva = Reserva::find($id);
        $reserva->fecha_reserva = $request->fecha_reserva;
        $reserva->personas = $request->personas;
        $reserva->save();

        UbicacionReserva::where('reserva_id', $id)->delete();
        // Submitted books
        $books = $request->books;
        $this->store_ubications($books, $reserva->id);

        return $reserva;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reserva = Reserva::find($id);
        $reserva->delete();
    }

    private function store_ubications($books, $reserva_id) {

        // Book records to be saved
        $book_records = [];

        // Add needed information to book records
        foreach($books as $book)
        {
            if(! empty($book))
            {
                // Formulate record that will be saved
                $book_records[] = [
                    'reserva_id' => $reserva_id,
                    'fila' => $book['index_row'],
                    'columna' => $book['index_col']
                ];
            }
        }

        // Insert UbicacionReserva
        UbicacionReserva::insert($book_records);
    }
}
