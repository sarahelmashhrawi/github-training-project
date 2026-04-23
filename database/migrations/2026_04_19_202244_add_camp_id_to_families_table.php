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
    Schema::table('families', function (Blueprint $table) {
        $table->foreignId('sector_id')->nullable()->constrained('sectors')->onDelete('set null');
        
        $table->foreignId('camp_id')->nullable()->after('sector_id')->constrained('camps')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('families', function (Blueprint $table) {
            //
        });
    }
};
