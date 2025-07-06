<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentInstruction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'bank_name',
        'bank_code',
        'swift_bic',
        'multi_currency_ac_no',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
