<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // إضافة حالة الحساب
            $table->boolean('is_active')->default(1); // مفعل أو موقوف
            
            // إضافة الخانات الوظيفية (كلها nullable عشان ما تعمل مشاكل)
            $table->string('job_title')->nullable(); // المسمى الوظيفي
            $table->string('work_location')->nullable(); // مكان العمل
            $table->string('contract_type')->nullable(); // نوع العقد (دائم، مؤقت، تطوع)
            $table->string('contract_duration')->nullable(); // مدة العقد
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'is_active', 'job_title', 'work_location', 'contract_type', 'contract_duration'
            ]);
        });
    }
};