<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceParty extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'type',
        'company_name',
        'address',
        'vat_no',
        'eori',
        'phone',
        'email',
    ];

    protected $casts = [
        'type' => 'string',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
