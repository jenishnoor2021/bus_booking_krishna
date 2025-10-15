<?php

namespace App\Models;

use App\Models\Bus;
use App\Models\Booking;
use App\Models\BusRoute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusSchedule extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function route()
    {
        return $this->belongsTo(BusRoute::class, 'bus_route_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
