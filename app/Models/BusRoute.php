<?php

namespace App\Models;

use App\Models\Bus;
use App\Models\PickupDrop;
use App\Models\BusSchedule;
use App\Models\JournyPlaces;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusRoute extends Model
{
    use HasFactory;

    protected $guarded = [];

    // public function bus()
    // {
    //     return $this->belongsTo(Bus::class, 'buses_id');
    // }

    public function from()
    {
        return $this->belongsTo(PickupDrop::class, 'from_id');
    }

    public function to()
    {
        return $this->belongsTo(PickupDrop::class, 'to_id');
    }

    public function schedules()
    {
        return $this->hasMany(BusSchedule::class);
    }

    public function journeyPlaces()
    {
        return $this->hasMany(JournyPlaces::class, 'bus_route_id');
    }
}
