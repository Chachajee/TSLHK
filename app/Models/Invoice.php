<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_no',
        'invoice_date',
        'ship_via',
        'tracking_no',
        'tax_id',
        'subtotal',
        'shipping',
        'total',
        'paid',
        'balance_due',
        'notes',
        'show_signature',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'subtotal' => 'decimal:2',
        'shipping' => 'decimal:2',
        'total' => 'decimal:2',
        'paid' => 'decimal:2',
        'balance_due' => 'decimal:2',
        'show_signature' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function parties()
    {
        return $this->hasMany(InvoiceParty::class);
    }

    public function paymentInstructions()
    {
        return $this->hasOne(PaymentInstruction::class);
    }

    public function billTo()
    {
        return $this->hasOne(InvoiceParty::class)->where('type', 'bill_to');
    }

    public function shipTo()
    {
        return $this->hasOne(InvoiceParty::class)->where('type', 'ship_to');
    }
}
