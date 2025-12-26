<?php

namespace App\Models;

use App\Models\PickupDrop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Locations extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pickupdrop()
    {
        return $this->belongsTo(PickupDrop::class, 'pickupdrop_id');
    }
}
