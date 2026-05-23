<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Family;

class EmergencyNeed extends Model
{
    protected $guarded = [];// اسمح بتخزين يا بيانات تأتي من الفورم

  
    public function family()
    {
        return $this->belongsTo(Family::class);
    }
    

   

}