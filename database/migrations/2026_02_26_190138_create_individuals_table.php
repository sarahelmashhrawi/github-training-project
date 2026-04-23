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
        Schema::create('individuals', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('family_id');
    $table->string('full_name');
    $table->date('dob')->nullable();
    $table->enum('gender', ['male','female','other'])->nullable();
    $table->string('relation_to_head')->nullable();
    $table->string('special_status')->nullable(); // e.g., injured, chronic, pregnant, disabled
    $table->timestamps();

    $table->foreign('family_id')->references('id')->on('families')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('individuals');
    }
};
