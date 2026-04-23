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
        $table->string('title'); 
        $table->string('location'); 
        $table->integer('target_families')->default(0); 
        $table->integer('total_capacity')->default(0); 
        $table->date('start_date'); 
        $table->date('end_date')->nullable(); 
        $table->enum('status', ['available', 'full'])->default('available'); 
        
        $table->text('description')->nullable(); 
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
