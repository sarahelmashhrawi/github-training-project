<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    // تحقق هل العمود موجود أم لا قبل الإضافة
    if (!Schema::hasColumn('users', 'role')) {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['manager', 'sector_supervisor', 'distributor', 'field_worker'])->default('field_worker');
        });
    }
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->enum('role', ['manager', 'sector_supervisor', 'distributor', 'field_worker'])->default('field_worker');
    });
}};
