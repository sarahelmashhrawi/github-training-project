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
    Schema::create('campaigns', function (Blueprint $table) {
        $table->id();
        $table->string('title'); // عنوان الحملة
        $table->string('location'); // مكان التنفيذ
        $table->integer('target_families')->default(0); // الهدف: كم عائلة بدنا نأوي؟
        $table->integer('total_capacity')->default(0); // سعة الخيم المتاحة
        $table->date('start_date'); // تاريخ البدء
        $table->date('end_date')->nullable(); // تاريخ الانتهاء
        $table->enum('status', ['available', 'full'])->default('available'); 
        
        $table->text('description')->nullable(); // وصف للمتبرع
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
