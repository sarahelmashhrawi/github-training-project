<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sector;
use App\Models\Family;

class Tent extends Model
{
    protected $guarded = [];

  
    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }


    public function families()
    {
        return $this->hasMany(Family::class);
    }
}