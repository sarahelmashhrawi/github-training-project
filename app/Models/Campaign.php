<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Receiving;

class Campaign extends Model
{
    protected $guarded = [];

 
    public function receivings()
    {
        return $this->hasMany(Receiving::class);
    }
}