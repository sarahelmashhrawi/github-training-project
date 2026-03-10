<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tent;

class Sector extends Model
{

    public function tents()
    {
        return $this->hasMany(Tent::class);
    }}