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
        Schema::create('payment_instruction_options', function (Blueprint $table) {
            $table->id();
            $table->string('option_name');
            $table->string('account_name');
            $table->string('account_number');
            $table->string('bank_code');
            $table->string('branch_code');
            $table->string('swift_code');
            $table->string('account_location');
            $table->string('bank_name');
            $table->string('bank_address');
            $table->string('account_type');
            $table->string('swift_bic');
            $table->string('multi_currency_ac_no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_instruction_options');
    }
}; 