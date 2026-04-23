<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sector extends Model
{
    use HasFactory,SoftDeletes;

    public function tents()
    {
        return $this->hasMany(Tent::class);
    }
    protected $fillable = ['name',
     'supervisor_id',
      'description'];
    }