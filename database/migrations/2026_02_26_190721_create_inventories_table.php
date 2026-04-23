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
      Schema::create('inventories', function (Blueprint $table) {
    $table->id();
    $table->string('item_name');
    $table->string('type')->nullable(); // physical, cash, medical
    $table->integer('quantity_available')->default(0);//الكمية المتاحة حاليا 
    $table->integer('total_quantity'); // الكمية الكلية
    $table->string('category');      // التصنيف (أدوات، طعام، مستلزمات طبية)
    $table->string('storage_location')->nullable(); // مكان الرف أو المستودع
    $table->enum('condition', ['جديد', 'مستعمل', 'يحتاج صيانة'])->default('جديد');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
