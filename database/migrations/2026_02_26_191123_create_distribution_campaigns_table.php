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
       Schema::create('distribution_campaigns', function (Blueprint $table) {
    $table->id();
    $table->string('campaign_name');
    $table->date('date_started')->nullable();
    $table->enum('status', ['active','closed'])->default('active');
    $table->string('target_group')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribution_campaigns');
    }
};
