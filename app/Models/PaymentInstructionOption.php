<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentInstructionOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'option_name',
        'account_name',
        'account_number',
        'bank_code',
        'branch_code',
        'swift_code',
        'account_location',
        'bank_name',
        'bank_address',
        'account_type',
        'swift_bic',
        'multi_currency_ac_no',
    ];

    /**
     * Get all payment instruction options for dropdown
     */
    public static function getOptionsForDropdown()
    {
        return self::orderBy('option_name')->get();
    }
} 