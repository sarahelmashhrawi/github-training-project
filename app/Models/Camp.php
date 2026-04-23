<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camp extends Model
{
    use HasFactory;

    /**
     * الحقول المسموح بتعبئتها لضمان حماية البيانات
     */
    protected $fillable = [
        'camp_number', 
        'name', 
        'location', 
        'max_capacity', 
        'needed_aid', 
        'status', 
        'sector_id'
    ];

    

    /**
     * علاقة: المخيم يتبع لقطاع واحد (Sector)
     */
    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    /**
     * علاقة: المخيم يحتوي على خيام كثيرة (Tents)
     */
    public function tents()
    {
        return $this->hasMany(Tent::class);
    }

    /**
     * علاقة: المخيم يسكن فيه العديد من العائلات (Families)
     */
    public function families()
    {
        return $this->hasMany(Family::class);
    }

    /**
     * علاقة: المخيم لديه العديد من الاحتياجات الطارئة (Emergency Needs)
     */
    public function emergencyNeeds()
    {
        return $this->hasMany(EmergencyNeed::class);
    }

    /**
     * علاقة: المخيم استلم العديد من دفعات المساعدات (Receivings)
     */
    public function receivings()
    {
        return $this->hasMany(Receiving::class);
    }
}