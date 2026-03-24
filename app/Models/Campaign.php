<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
protected $fillable = [
    'title', 
    'location', 
    'start_date', 
    'end_date', 
    'status',
];
    /**
     * علاقة الحملة بعمليات الاستلام
     * (كم غرض توزع ضمن هذه الحملة)
     */
    public function receivings()
    {
        return $this->hasMany(Receiving::class);
    }

    /**
     * (عشان نعرف كم عائلة سكنت في هادي الحملة بالظبط)
     */
    public function families()
    {
        return $this->hasMany(Family::class);
    }
}