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
        Schema::table('payment_instructions', function (Blueprint $table) {
            $table->string('account_name')->nullable()->after('invoice_id');
            $table->string('account_number')->nullable()->after('account_name');
            $table->string('branch_code')->nullable()->after('bank_code');
            $table->string('swift_code')->nullable()->after('swift_bic');
            $table->string('account_location')->nullable()->after('swift_code');
            $table->string('bank_address')->nullable()->after('account_location');
            $table->string('account_type')->nullable()->after('bank_address');
            $table->string('payment_instruction_option')->nullable()->after('account_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_instructions', function (Blueprint $table) {
            $table->dropColumn([
                'account_name',
                'account_number',
                'branch_code',
                'swift_code',
                'account_location',
                'bank_address',
                'account_type',
                'payment_instruction_option'
            ]);
        });
    }
}; 