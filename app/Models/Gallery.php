<?php

namespace App\Models;

use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $uploads = '/gallery/';

    public function getFileAttribute($photo)
    {
        return $this->uploads . $photo;
    }

    public function Events()
    {
        return $this->belongsTo(Event::class);
    }
}
