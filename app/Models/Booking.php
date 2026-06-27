<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'bus_schedule_id', 'seat_numbers', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function busSchedule()
    {
        return $this->belongsTo(BusSchedule::class);
    }
}
