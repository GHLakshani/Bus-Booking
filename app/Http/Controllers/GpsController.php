<?php

namespace App\Http\Controllers;

use App\Models\BusLocation;
use App\Models\BusSchedule;
use Illuminate\Http\Request;

class GpsController extends Controller
{
    public function trackBus(BusSchedule $busSchedule)
    {
        $location = BusLocation::where('bus_schedule_id', $busSchedule->id)->latest()->first();
        return view('track-bus', compact('busSchedule', 'location'));
    }

    // API: GPS device / operator POSTs live location
    public function updateLocation(Request $request)
    {
        $data = $request->validate([
            'bus_schedule_id' => 'required|exists:bus_schedules,id',
            'latitude'        => 'required|numeric|between:-90,90',
            'longitude'       => 'required|numeric|between:-180,180',
        ]);

        $location = BusLocation::updateOrCreate(
            ['bus_schedule_id' => $data['bus_schedule_id']],
            ['latitude' => $data['latitude'], 'longitude' => $data['longitude']]
        );

        return response()->json(['success' => true, 'location' => $location]);
    }

    // API: passenger polls for current bus location
    public function getLocation(BusSchedule $busSchedule)
    {
        $location = BusLocation::where('bus_schedule_id', $busSchedule->id)->latest()->first();

        if (!$location) {
            return response()->json(['available' => false]);
        }

        return response()->json([
            'available'  => true,
            'latitude'   => $location->latitude,
            'longitude'  => $location->longitude,
            'updated_at' => $location->updated_at->diffForHumans(),
        ]);
    }

    // Admin form to simulate GPS update
    public function adminGpsForm()
    {
        $buses = BusSchedule::where('schedule_date', '>=', now()->toDateString())->get();
        return view('admin.update-gps', compact('buses'));
    }

    public function adminGpsSubmit(Request $request)
    {
        $data = $request->validate([
            'bus_schedule_id' => 'required|exists:bus_schedules,id',
            'latitude'        => 'required|numeric|between:-90,90',
            'longitude'       => 'required|numeric|between:-180,180',
        ]);

        BusLocation::updateOrCreate(
            ['bus_schedule_id' => $data['bus_schedule_id']],
            ['latitude' => $data['latitude'], 'longitude' => $data['longitude']]
        );

        return back()->with('success', 'Bus location updated.');
    }
}
