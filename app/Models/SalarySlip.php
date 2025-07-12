<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalarySlip extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_name',
        'employee_id_number',
        'designation',
        'period_from',
        'period_to',
        'generated_date',
    ];

    protected $casts = [
        'period_from' => 'date',
        'period_to' => 'date',
        'generated_date' => 'date',
    ];

    /**
     * Get the salary payments for this salary slip.
     */
    public function payments()
    {
        return $this->hasMany(SalaryPayment::class);
    }

    /**
     * Get the salary deductions for this salary slip.
     */
    public function deductions()
    {
        return $this->hasMany(SalaryDeduction::class);
    }

    /**
     * Get the total amount paid for this salary slip.
     */
    public function getTotalPaidAttribute()
    {
        return $this->payments()->sum('amount');
    }

    /**
     * Get the total deductions for this salary slip.
     */
    public function getTotalDeductionsAttribute()
    {
        return $this->deductions()->sum('amount');
    }

    /**
     * Get the net salary (total paid - total deductions).
     */
    public function getNetSalaryAttribute()
    {
        return $this->total_paid - $this->total_deductions;
    }

    /**
     * Get the period as a formatted string.
     */
    public function getPeriodAttribute()
    {
        return $this->period_from->format('M d, Y') . ' - ' . $this->period_to->format('M d, Y');
    }
}
