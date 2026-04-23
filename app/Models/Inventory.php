<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
protected $fillable = [
        'item_name',
        'type',
        'quantity_available',
        'total_quantity',
        'category',
        'storage_location',
        'condition'
    ];

    /**
     * تحويل أنواع البيانات لضمان التعامل الصحيح معها
     */
    protected $casts = [
        'quantity_available' => 'integer',
        'total_quantity'     => 'integer',
    ];}