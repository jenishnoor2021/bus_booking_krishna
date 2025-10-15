<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'seat_numbers' => 'array',
    ];

    public function schedule()
    {
        return $this->belongsTo(BusSchedule::class, 'bus_schedule_id');
    }
}
