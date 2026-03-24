<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emergency_needs', function (Blueprint $table) {
            $table->id();
            // التعديل هنا: الربط مع العائلة بدل الخيمة
            $table->unsignedBigInteger('family_id'); 
            
            $table->string('type_of_need'); // نوع الاحتياج (دواء، حليب، غطاء)
            $table->text('description')->nullable();
            
            // مستويات الخطورة والحالة
            $table->enum('urgency_level', ['critical', 'high', 'medium', 'low'])->default('medium');
            $table->enum('status', ['pending', 'in_progress', 'resolved'])->default('pending');
            
            // الموظف المسؤول عن التقرير
            $table->unsignedBigInteger('reported_by')->nullable(); 
            
            $table->timestamps();

            // إعداد العلاقات (Foreign Keys)
            $table->foreign('family_id')->references('id')->on('families')->onDelete('cascade');
            $table->foreign('reported_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emergency_needs');
    }
};
