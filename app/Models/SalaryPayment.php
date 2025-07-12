<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'salary_slip_id',
        'payment_method',
        'amount',
        'received_date',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'received_date' => 'date',
    ];

    /**
     * Get the salary slip that owns this payment.
     */
    public function salarySlip()
    {
        return $this->belongsTo(SalarySlip::class);
    }

    /**
     * Get the formatted amount.
     */
    public function getFormattedAmountAttribute()
    {
        return '$' . number_format($this->amount, 2);
    }

    /**
     * Get the formatted received date.
     */
    public function getFormattedReceivedDateAttribute()
    {
        return $this->received_date->format('M d, Y');
    }
}
