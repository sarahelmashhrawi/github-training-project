<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Family;

class EmergencyNeed extends Model
{
    protected $guarded = [];

  
    public function family()
    {
        return $this->belongsTo(Family::class);
    }
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    // العلاقة: هذا الاحتياج يخص مخيم معين
public function camp()
{
    return $this->belongsTo(Camp::class);
}
}