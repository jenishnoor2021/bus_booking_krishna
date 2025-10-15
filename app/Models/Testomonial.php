<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testomonial extends Model
{
    use HasFactory;

    protected $uploads = '/testomonialimg/';

    protected $guarded = [];

    public function getFileAttribute($photo)
    {

        return $this->uploads . $photo;
    }
}
