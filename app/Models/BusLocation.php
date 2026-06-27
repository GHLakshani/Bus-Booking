<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusLocation extends Model
{
    protected $fillable = ['bus_schedule_id', 'latitude', 'longitude'];

    public function busSchedule()
    {
        return $this->belongsTo(BusSchedule::class);
    }
}
