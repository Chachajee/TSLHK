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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no');
            $table->date('invoice_date');
            $table->string('ship_via');
            $table->string('tracking_no');
            $table->string('tax_id')->nullable();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('shipping', 10, 2);
            $table->decimal('total', 10, 2);
            $table->decimal('paid', 10, 2);
            $table->decimal('balance_due', 10, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
