<?php

namespace App\Models;

use App\Models\BusRoute;
use App\Models\BusSchedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bus extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $uploads = '/bus/';

    public function getFileAttribute($photo)
    {
        return $this->uploads . $photo;
    }

    public function routes()
    {
        return $this->hasMany(BusRoute::class, 'buses_id');
    }

    public function schedules()
    {
        return $this->hasMany(BusSchedule::class);
    }
}
