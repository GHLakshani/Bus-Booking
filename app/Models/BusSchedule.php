<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusSchedule extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'schedule_id', 'route_from', 'route_to', 'departure_time',
        'bus_model', 'depot_name', 'fare', 'available_seats',
        'duration', 'bus_type', 'schedule_date', 'bus_image', 'status', 'delay_minutes',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function location()
    {
        return $this->hasOne(BusLocation::class)->latestOfMany();
    }

    public function bookedSeatNumbers(): array
    {
        $seats = [];
        foreach ($this->bookings()->where('status', 'confirmed')->get() as $booking) {
            foreach (explode(',', $booking->seat_numbers) as $s) {
                $trimmed = trim($s);
                if ($trimmed !== '') {
                    $seats[] = $trimmed;
                }
            }
        }
        return $seats;
    }
}
