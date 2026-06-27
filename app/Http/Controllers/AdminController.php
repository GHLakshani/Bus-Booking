<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BusSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'totalBuses'    => BusSchedule::count(),
            'totalBookings' => Booking::count(),
            'totalUsers'    => User::where('user_type', 'user')->count(),
            'recentBookings'=> Booking::with(['user', 'busSchedule'])->latest()->take(5)->get(),
        ]);
    }

    // ── Bus Schedule CRUD ─────────────────────────────────────

    public function busIndex()
    {
        return view('admin.bus-details', ['buses' => BusSchedule::latest()->get()]);
    }

    public function busCreate()
    {
        return view('admin.add-bus');
    }

    public function busStore(Request $request)
    {
        $data = $request->validate([
            'schedule_id'    => 'required|string|unique:bus_schedules',
            'route_from'     => 'required|string',
            'route_to'       => 'required|string',
            'departure_time' => 'required',
            'bus_model'      => 'required|string',
            'depot_name'     => 'required|string',
            'fare'           => 'required|numeric|min:0',
            'available_seats'=> 'required|integer|min:1|max:100',
            'duration'       => 'required|string',
            'bus_type'       => 'required|string',
            'schedule_date'  => 'required|date',
            'bus_image'      => 'nullable|image|max:10240',
        ]);

        if ($request->hasFile('bus_image')) {
            $data['bus_image'] = $request->file('bus_image')->move(
                public_path('uploads'), $request->file('bus_image')->getClientOriginalName()
            )->getFilename();
        }

        BusSchedule::create($data);
        return redirect()->route('admin.buses')->with('success', 'Bus schedule added.');
    }

    public function busEdit(BusSchedule $busSchedule)
    {
        return view('admin.edit-bus', compact('busSchedule'));
    }

    public function busUpdate(Request $request, BusSchedule $busSchedule)
    {
        $data = $request->validate([
            'route_from'     => 'required|string',
            'route_to'       => 'required|string',
            'departure_time' => 'required',
            'bus_model'      => 'required|string',
            'depot_name'     => 'required|string',
            'fare'           => 'required|numeric|min:0',
            'available_seats'=> 'required|integer|min:0|max:100',
            'duration'       => 'required|string',
            'bus_type'       => 'required|string',
            'schedule_date'  => 'required|date',
            'delay_minutes'  => 'nullable|integer|min:0',
            'bus_image'      => 'nullable|image|max:10240',
        ]);

        if ($request->hasFile('bus_image')) {
            $data['bus_image'] = $request->file('bus_image')->move(
                public_path('uploads'), $request->file('bus_image')->getClientOriginalName()
            )->getFilename();
        }

        $busSchedule->update($data);
        return redirect()->route('admin.buses')->with('success', 'Bus schedule updated.');
    }

    public function busDestroy(BusSchedule $busSchedule)
    {
        $busSchedule->delete();
        return redirect()->route('admin.buses')->with('success', 'Bus schedule deleted.');
    }

    // ── Bookings ──────────────────────────────────────────────

    public function viewBookings()
    {
        $bookings = Booking::with(['user', 'busSchedule'])->latest()->get();
        return view('admin.view-bookings', compact('bookings'));
    }

    // ── Users ─────────────────────────────────────────────────

    public function manageUsers()
    {
        $users = User::where('user_type', 'user')->latest()->get();
        return view('admin.manage-users', compact('users'));
    }

    // ── Delay Notifications ───────────────────────────────────

    public function notifyDelayForm()
    {
        $buses = BusSchedule::where('schedule_date', '>=', now()->toDateString())->get();
        return view('admin.notify-delay', compact('buses'));
    }

    public function notifyDelaySubmit(Request $request)
    {
        $request->validate([
            'bus_schedule_id' => 'required|exists:bus_schedules,id',
            'delay_minutes'   => 'required|integer|min:1',
        ]);

        $schedule = BusSchedule::find($request->bus_schedule_id);
        $schedule->update(['delay_minutes' => $request->delay_minutes]);

        // Email all confirmed passengers
        $bookings = Booking::with('user')
            ->where('bus_schedule_id', $schedule->id)
            ->where('status', 'confirmed')
            ->get();

        $sent = 0;
        foreach ($bookings as $booking) {
            try {
                Mail::raw(
                    "Dear {$booking->user->first_name},\n\nPlease note that bus {$schedule->schedule_id} on route {$schedule->route_from} → {$schedule->route_to} scheduled for {$schedule->schedule_date} is delayed by {$request->delay_minutes} minutes.\n\nWe apologize for the inconvenience.\n\nBusGoes Team",
                    function ($message) use ($booking) {
                        $message->to($booking->user->email)->subject('BusGoes – Service Delay Notification');
                    }
                );
                $sent++;
            } catch (\Exception $e) {
                // continue to next passenger
            }
        }

        return back()->with('success', "Delay updated. Notifications sent to {$sent} passenger(s).");
    }

    // ── API Token Management ───────────────────────────────────

    public function apiTokens()
    {
        $tokens = DB::table('api_tokens')->orderByDesc('created_at')->get();
        return view('admin.api-tokens', compact('tokens'));
    }

    public function generateApiToken(Request $request)
    {
        $request->validate(['label' => 'required|string|max:100']);

        $token = Str::random(64);
        DB::table('api_tokens')->insert([
            'token'      => $token,
            'label'      => $request->label,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('new_token', $token)->with('success', 'API token generated.');
    }

    public function deleteApiToken(int $id)
    {
        DB::table('api_tokens')->where('id', $id)->delete();
        return back()->with('success', 'API token revoked.');
    }
}
