<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ReservationController extends Controller
{
    public function index()
    {
        $props['title'] = 'Reservation';
        $props['reservations'] = Reservation::where('customer_id', session('id'))->get();
        return view('user.reservation', $props);
    }

    public function makeReservation(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'date' => 'required|date',
        ]);

        if ($valid->fails()) {
            return response()->json(['message' => $valid->errors()->first(), 'success' => false]);
        }

        Reservation::create([
            'customer_id' => session('id'),
            'date' => $request->date,
            'status' => 0,
        ]);

        return response()->json(['message' => 'Reservation created successfully', 'success' => true]);
    }

    public function cancelReservation(Reservation $reservation)
    {
        if ($reservation->customer_id !== session('id')) {
            return response()->json(['success' => false, 'message' => 'Anda tidak berwenang melakukan aksi ini.'], 403);
        }

        if ($reservation->status !== 0) {
            return response()->json(['success' => false, 'message' => 'Reservasi ini tidak dapat dibatalkan lagi.'], 422);
        }

        $reservation->delete();

        return response()->json(['success' => true, 'message' => 'Reservasi berhasil dibatalkan.']);
    }
}
