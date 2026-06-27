<?php

namespace App\Http\Controllers;

use App\Models\BusSchedule;
use Illuminate\Http\Request;

class BusScheduleController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function search(Request $request)
    {
        $request->validate([
            'route_from' => 'required|string',
            'route_to'   => 'required|string',
            'bus_type'   => 'required|string',
            'date'       => 'required|date',
        ]);

        $buses = BusSchedule::where('route_from', $request->route_from)
            ->where('route_to', $request->route_to)
            ->where('bus_type', $request->bus_type)
            ->where('schedule_date', $request->date)
            ->where('status', 'Y')
            ->get();

        return view('search-results', compact('buses', 'request'));
    }

    public function seatBooking(BusSchedule $busSchedule)
    {
        $bookedSeats = $busSchedule->bookedSeatNumbers();
        return view('seat-booking', compact('busSchedule', 'bookedSeats'));
    }
}
