<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Individual extends Model
{
    use HasFactory;

    // الحقول المسموح إدخالها
   protected $fillable = [

    'family_id', 'full_name', 'id_number', 'dob', 'gender', 'relation_to_head', 
    'has_disability', 'disability_type', 'has_chronic_disease', 'chronic_disease_name' 
];

    // علاقة الفرد بالعائلة (الفرد يتبع لعائلة واحدة)
    public function family()
    {
        return $this->belongsTo(Family::class);
    }

public function getAgeAttribute()
    {
        return $this->dob ? Carbon::parse($this->dob)->age : 'غير محدد';
    }
    }
