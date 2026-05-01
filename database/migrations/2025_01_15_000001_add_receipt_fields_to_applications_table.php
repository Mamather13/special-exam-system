<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->string('or_number')->nullable()->after('status');
            $table->decimal('amount_paid', 8, 2)->nullable()->after('or_number');
            $table->string('receipt_path')->nullable()->after('amount_paid');
            $table->timestamp('receipt_at')->nullable()->after('receipt_path');
        });
    }

    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropColumn(['or_number', 'amount_paid', 'receipt_path', 'receipt_at']);
        });
    }
};