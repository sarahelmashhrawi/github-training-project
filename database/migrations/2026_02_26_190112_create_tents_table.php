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
       Schema::create('tents', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('sector_id');
    $table->string('tent_number');
    $table->enum('condition', ['good','worn','needs_shade','flooded'])->default('good');
    $table->integer('capacity')->default(4);
    $table->timestamps();

    $table->foreign('sector_id')->references('id')->on('sectors')->onDelete('cascade');
    $table->unique(['sector_id','tent_number']);
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tents');
    }
};
