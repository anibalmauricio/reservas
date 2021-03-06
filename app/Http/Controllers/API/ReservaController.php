<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Reserva;
use App\UbicacionReserva;
use Illuminate\Support\Facades\Storage;

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
        return Reserva::where('user_id', auth()->id())->orderBy('fecha_reserva', 'desc')->get();
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
        $digits = 3;
        $random = 'NRS-'.str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
        $reserva->codigo_reserva = $random;
        $reserva->personas = $request->personas;
        $reserva->user_id = auth()->id();
        $reserva->save();

        // Submitted books
        $books = $request->books;

        $this->store_ubications($books, $reserva->id);

        $exists = Storage::disk('public')->exists('file.txt');
        $txt = 'Se ha guardado una nueva reserva. Esta es la información de la reserva creada.\nCodigo Reserva:'.$random.'.\nFecha Reserva:'.$request->fecha_reserva.'\nNúmero de personas:'.$request->personas.'\nCreado en:'.date('d-m-Y H:i:s');
        if ($exists) {
            Storage::append('file.txt', $txt);
        } else {
            Storage::disk('public')->put('file.txt', $txt);
        }

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

        $exists = Storage::disk('public')->exists('file.txt');
        $txt = 'Se ha actualizado una reserva. Esta es la información de la reserva actualizada.\nCodigo Reserva:'.$reserva->codigo_reserva.'.\nFecha Reserva:'.$request->fecha_reserva.'\nNúmero de personas:'.$request->personas.'\nCreado en:'.date('d-m-Y H:i:s');
        if ($exists) {
            Storage::append('file.txt', $txt);
        } else {
            Storage::disk('public')->put('file.txt', $txt);
        }
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
                    'row' => $book['index_row'],
                    'col' => $book['index_col']
                ];
            }
        }

        // Insert UbicacionReserva
        UbicacionReserva::insert($book_records);
    }

}
