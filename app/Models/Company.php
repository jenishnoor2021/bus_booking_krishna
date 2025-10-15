<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $uploads = '/companysign/';
    protected $uploadlogo = '/companylogo/';

    public function getSignAttribute($photo)
    {
        return $this->uploads . $photo;
    }

    public function getLogoAttribute($photo)
    {
        return $this->uploadlogo . $photo;
    }

    protected $casts = [
        'fb_token_expires_at' => 'datetime',
    ];
}
