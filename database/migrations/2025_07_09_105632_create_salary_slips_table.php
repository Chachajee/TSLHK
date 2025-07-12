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
        Schema::create('salary_slips', function (Blueprint $table) {
            $table->id();
            $table->string('employee_name'); // e.g., "Mr. Khan, Ozaif"
            $table->string('employee_id_number'); // e.g., "Y737632(2)"
            $table->string('designation'); // e.g., "Quality Control Manager"
            $table->date('period_from'); // e.g., "2024-09-01"
            $table->date('period_to'); // e.g., "2024-12-31"
            $table->date('generated_date'); // the date the slip was issued
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_slips');
    }
};
