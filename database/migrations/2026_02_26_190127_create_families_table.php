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
       Schema::create('families', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('tent_id');
    $table->string('head_name');
    $table->string('id_number')->nullable();
    $table->string('phone')->nullable();
    $table->string('original_area')->nullable();
    $table->enum('family_type', ['normal','female_headed','orphans'])->default('normal');
    $table->timestamps();

    $table->foreign('tent_id')->references('id')->on('tents')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('families');
    }
};
