<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusLocation extends Model
{
    use SoftDeletes;
    protected $fillable = ['bus_schedule_id', 'latitude', 'longitude'];

    public function busSchedule()
    {
        return $this->belongsTo(BusSchedule::class);
    }
}
