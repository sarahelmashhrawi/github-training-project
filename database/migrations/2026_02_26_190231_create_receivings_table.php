<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('receivings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id');
            $table->unsignedBigInteger('family_id');
            $table->unsignedBigInteger('inventory_id');
            $table->unsignedBigInteger('user_id')->nullable(); 
            $table->integer('quantity_received')->default(1);
            $table->timestamp('received_at')->useCurrent();
            $table->timestamps();
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');//اذا تم حذف الحملة او العائلة سيتم حذف سجلات الاستلام المرتبطة
            $table->foreign('family_id')->references('id')->on('families')->onDelete('cascade');
            $table->foreign('inventory_id')->references('id')->on('inventories')->onDelete('restrict');//يمنع حذف الصنف من النظام اذا كان هناك اشخاص استلموه
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');//اذا تم حذف حساب الموظف الذي سلم الطرد يبقى سجل الاستلام موجود
            $table->unique(['campaign_id','family_id','inventory_id'], 'unique_receipt_per_campaign_family_item');//منع العائلة الواحدة من استلام نفس الصنغ مرتين
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receivings');
    }
};