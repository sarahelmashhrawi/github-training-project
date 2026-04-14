<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Individual;
class Family extends Model
{
    use HasFactory;

    // الحقول المسموح إدخالها
    protected $fillable = [
        'tent_id', 
        'head_name', 
        'id_number', 
        'phone', 
        'dob',
        'original_area', 
        'current_area',
        'family_type',
        'marital_status'
    ];

    // علاقة العائلة بالخيمة (عائلة واحدة تتبع لخيمة واحدة)
    public function tent()
    {
return $this->belongsTo(Tent::class, 'tent_id');
    }

    // علاقة العائلة بالأفراد (عائلة واحدة لها عدة أفراد)
    public function individuals()
    {
        return $this->hasMany(Individual::class);
    }


    
}