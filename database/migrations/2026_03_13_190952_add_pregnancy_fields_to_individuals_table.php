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
        Schema::table('individuals', function (Blueprint $table) {
            // إضافة حقول الحمل والرضاعة كقيم منطقية (Boolean) والافتراضي تبعها 0 (لا)
            //$table->boolean('is_pregnant')->default(0)->after('gender');
            //$table->boolean('is_breastfeeding')->default(0)->after('is_pregnant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('individuals', function (Blueprint $table) {
            // لحذف الحقول في حال عمل التراجع (rollback)
            $table->dropColumn(['is_pregnant', 'is_breastfeeding']);
        });
    }
};