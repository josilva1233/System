<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'reservation_date' => 'required|date',
        'reservation_time' => 'required',
        'resource' => 'required|string|max:255',
    ]);

    $reservation = Reservation::create([
        'user_id' => Auth::id(),
        'reservation_date' => $validated['reservation_date'],
        'reservation_time' => $validated['reservation_time'],
        'resource' => $validated['resource'],
        'is_confirmed' => false,
    ]);

    // Registrar o log no MongoDB
    ReservationLog::create([
        'reservation_id' => $reservation->id,
        'action' => 'created',
        'timestamp' => now(),
        'user_id' => Auth::id(),
    ]);

    return response()->json($reservation);
}

}
