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

public function camp()
{
    return $this->belongsTo(Camp::class);
}
   
// علاقة الخيمة بالعائلات (خيمة واحدة قد تحتوي على أكثر من عائلة)
    public function families()
    {
        return $this->hasMany(Family::class);
    }    }