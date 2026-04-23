<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('individuals', function (Blueprint $table) {
            // إضافة العمود ليكون نصياً (لحفظ مسار الملف) وقابلاً للفراغ (لأنه اختياري)
            $table->string('medical_attachment')->nullable()->after('chronic_disease_name');
        });
    }

    public function down()
    {
        Schema::table('individuals', function (Blueprint $table) {
            $table->dropColumn('medical_attachment');
        });
    }
};