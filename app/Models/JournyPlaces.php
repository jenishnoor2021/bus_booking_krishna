<?php

namespace App\Models;

use App\Models\BusRoute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JournyPlaces extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function route()
    {
        return $this->belongsTo(BusRoute::class, 'bus_route_id');
    }
}
