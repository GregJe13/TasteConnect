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
}
