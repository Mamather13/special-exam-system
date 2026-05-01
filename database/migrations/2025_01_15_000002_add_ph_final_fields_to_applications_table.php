<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->text('ph_final_remarks')->nullable()->after('receipt_at');
            $table->timestamp('ph_final_at')->nullable()->after('ph_final_remarks');
            $table->unsignedBigInteger('ph_final_by')->nullable()->after('ph_final_at');
        });
    }

    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropColumn(['ph_final_remarks', 'ph_final_at', 'ph_final_by']);
        });
    }
};