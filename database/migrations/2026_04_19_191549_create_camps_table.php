<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('camps', function (Blueprint $table) {
        $table->id(); 
        
        // 1. البيانات الأساسية للمخيم
        $table->string('camp_number')->unique(); // رقم المخيم (مثلاً: CAMP-001)
        $table->string('name'); // اسم المخيم (مثلاً: مخيم النور)
        $table->string('location'); // الموقع الجغرافي (رابط خرائط أو وصف)

        // 2. السعة والمواصفات
        $table->integer('max_capacity')->default(0); // السعة القصوى للخيام
        $table->text('needed_aid')->nullable(); // وصف المساعدات التي يحتاجها المخيم حالياً

        // 3. الحالة (نشط، ممتلئ، قيد التجهيز)
        $table->enum('status', ['active', 'full', 'under_construction'])->default('active');

        // 4.المفتاح الأجنبي (الربط مع جدول القطاعات 
        $table->foreignId('sector_id')->constrained('sectors')->onDelete('cascade');

        $table->timestamps();  
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camps');
    }
};
