<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BusSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function store(Request $request, BusSchedule $busSchedule)
    {
        $request->validate(['selected_seats' => 'required|string']);

        $selectedSeats = json_decode($request->selected_seats, true);
        if (empty($selectedSeats)) {
            return response()->json(['error' => 'No seats selected.'], 422);
        }

        // Server-side double-booking check
        $alreadyBooked = $busSchedule->bookedSeatNumbers();
        $conflict = array_intersect($selectedSeats, $alreadyBooked);
        if (!empty($conflict)) {
            return response()->json(['error' => 'Seats ' . implode(', ', $conflict) . ' are already booked.'], 409);
        }

        $booking = Booking::create([
            'user_id'        => auth()->id(),
            'bus_schedule_id'=> $busSchedule->id,
            'seat_numbers'   => implode(', ', $selectedSeats),
            'status'         => 'confirmed',
        ]);

        // Update available seats count
        $busSchedule->decrement('available_seats', count($selectedSeats));

        // Send confirmation email
        try {
            $user = auth()->user();
            Mail::raw(
                "Dear {$user->first_name},\n\nYour booking is confirmed!\n\nRoute: {$busSchedule->route_from} → {$busSchedule->route_to}\nDate: {$busSchedule->schedule_date}\nDeparture: {$busSchedule->departure_time}\nSeats: " . implode(', ', $selectedSeats) . "\nFare: Rs. {$busSchedule->fare} per seat\n\nThank you for choosing BusGoes!",
                function ($message) use ($user) {
                    $message->to($user->email)->subject('BusGoes – Booking Confirmation');
                }
            );
        } catch (\Exception $e) {
            // Email failure should not block booking
        }

        return response()->json(['success' => true, 'booking_id' => $booking->id]);
    }

    public function myBookings()
    {
        $bookings = Booking::with('busSchedule')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('my-bookings', compact('bookings'));
    }

    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->status === 'confirmed') {
            $booking->update(['status' => 'cancelled']);
            $seatCount = count(array_filter(array_map('trim', explode(',', $booking->seat_numbers))));
            $booking->busSchedule->increment('available_seats', $seatCount);
        }

        return back()->with('success', 'Booking cancelled successfully.');
    }

    public function myAccount()
    {
        return view('my-account', ['user' => auth()->user()]);
    }
}
