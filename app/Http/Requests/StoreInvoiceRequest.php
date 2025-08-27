<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Invoice Header
            'invoice_no' => 'required|string|max:255|unique:invoices,invoice_no',
            'invoice_date' => 'required|date',
            
            // Bill To
            'bill_company_name' => 'required|string|max:255',
            'bill_address' => 'required|string',
            'bill_vat_no' => 'required|string|max:255',
            'bill_eori' => 'required|string|max:255',
            'bill_phone' => 'required|string|max:255',
            'bill_email' => 'required|email|max:255',
            
            // Ship To
            'ship_company_name' => 'required|string|max:255',
            'ship_address' => 'required|string',
            'ship_vat_no' => 'required|string|max:255',
            'ship_eori' => 'required|string|max:255',
            'ship_phone' => 'required|string|max:255',
            'ship_email' => 'required|email|max:255',
            
            // Shipping Details
            'ship_via' => 'required|string|max:255',
            'tracking_no' => 'required|string|max:255',
            'tax_id' => 'nullable|string|max:255',
            
            // Invoice Items
            'description' => 'required|array|min:1',
            'description.*' => 'required|string',
            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|integer|min:1',
            'rate' => 'required|array|min:1',
            'rate.*' => 'required|numeric|min:0',
            'amount' => 'required|array|min:1',
            'amount.*' => 'required|numeric|min:0',
            
            // Invoice Totals
            'subtotal' => 'required|numeric|min:0',
            'shipping' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'paid' => 'required|numeric|min:0',
            'balance_due' => 'required|numeric',
            
            // Notes
            'notes' => 'nullable|string',
            
            // Signature
            'show_signature' => 'nullable|boolean',
            
            // Payment Instructions
            'payment_instruction_option' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'bank_code' => 'required|string|max:255',
            'branch_code' => 'required|string|max:255',
            'swift_bic' => 'required|string|max:255',
            'swift_code' => 'required|string|max:255',
            'account_location' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'bank_address' => 'required|string|max:255',
            'account_type' => 'required|string|max:255',
            'multi_currency_ac_no' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'invoice_no.unique' => 'This invoice number already exists.',
            'description.required' => 'At least one invoice item is required.',
            'description.min' => 'At least one invoice item is required.',
            'quantity.required' => 'Quantity is required for all items.',
            'rate.required' => 'Rate is required for all items.',
            'amount.required' => 'Amount is required for all items.',
        ];
    }
}
