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
    $table->boolean('has_disability')->default(0)->after('gender');
    $table->string('disability_type')->nullable()->after('has_disability');
    
    $table->boolean('has_chronic_disease')->default(0)->after('disability_type');
    $table->string('chronic_disease_name')->nullable()->after('has_chronic_disease');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('individuals', function (Blueprint $table) {
            //
        });
    }
};
