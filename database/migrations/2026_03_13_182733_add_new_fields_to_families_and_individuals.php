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
    // إضافة الحالة الاجتماعية لرب الأسرة
    Schema::table('families', function (Blueprint $table) {
        $table->string('marital_status')->nullable()->after('head_name'); 
    });

    // إضافة أسئلة الحمل والرضاعة للأفراد
    Schema::table('individuals', function (Blueprint $table) {
        $table->boolean('is_pregnant')->default(0)->after('has_chronic_disease');
        $table->boolean('is_breastfeeding')->default(0)->after('is_pregnant');
    });
}

public function down()
{
    Schema::table('families', function (Blueprint $table) {
        $table->dropColumn('marital_status');
    });

    Schema::table('individuals', function (Blueprint $table) {
        $table->dropColumn(['is_pregnant', 'is_breastfeeding']);
    });
}
};
