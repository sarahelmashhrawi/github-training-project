<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Family;
use App\Models\Campaign;

class Receiving extends Model
{
    protected $guarded = []; //السماح بادخال البيانات في جميع الحقول دون استثناء

   
    public function family()
    {
        return $this->belongsTo(Family::class);
    }


    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function inventory()
{
    return $this->belongsTo(Inventory::class);
}
public function user()
    {
        return $this->belongsTo(User::class);
    }
}