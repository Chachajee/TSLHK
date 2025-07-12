<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'amount_paid',
        'amount_spent',
        'credit_balance',
        'notes',
    ];

    protected $casts = [
        'amount_paid' => 'decimal:2',
        'amount_spent' => 'decimal:2',
        'credit_balance' => 'decimal:2',
    ];

    /**
     * Calculate credit balance based on paid and spent amounts
     */
    public function calculateCreditBalance()
    {
        return $this->amount_paid - $this->amount_spent;
    }

    /**
     * Get formatted amount paid
     */
    public function getFormattedAmountPaidAttribute()
    {
        return '₹' . number_format($this->amount_paid, 2);
    }

    /**
     * Get formatted amount spent
     */
    public function getFormattedAmountSpentAttribute()
    {
        return '₹' . number_format($this->amount_spent, 2);
    }

    /**
     * Get formatted credit balance
     */
    public function getFormattedCreditBalanceAttribute()
    {
        return '₹' . number_format($this->credit_balance, 2);
    }
}
