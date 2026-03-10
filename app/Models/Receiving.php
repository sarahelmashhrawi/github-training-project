<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Family;
use App\Models\Campaign;

class Receiving extends Model
{
    protected $guarded = [];

   
    public function family()
    {
        return $this->belongsTo(Family::class);
    }


    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}