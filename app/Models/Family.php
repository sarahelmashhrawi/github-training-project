<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tent;
use App\Models\Individual;

class Family extends Model
{
    protected $guarded = [];

    public function tent()
    {
        return $this->belongsTo(Tent::class);
    }

    public function individuals()
    {
        return $this->hasMany(Individual::class);
    }
}