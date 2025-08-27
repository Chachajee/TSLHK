<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCreditNoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'amount_paid' => $this->cleanCurrencyValue($this->input('amount_paid')),
            'amount_spent' => $this->cleanCurrencyValue($this->input('amount_spent')),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'amount_paid' => 'required|numeric|min:0',
            'amount_spent' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
            'show_signature' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'customer_name.required' => 'Customer name is required.',
            'customer_name.string' => 'Customer name must be a valid text.',
            'customer_name.max' => 'Customer name cannot exceed 255 characters.',
            'amount_paid.required' => 'Amount paid is required.',
            'amount_paid.numeric' => 'Amount paid must be a valid number.',
            'amount_paid.min' => 'Amount paid cannot be negative.',
            'amount_spent.required' => 'Amount spent is required.',
            'amount_spent.numeric' => 'Amount spent must be a valid number.',
            'amount_spent.min' => 'Amount spent cannot be negative.',
            'notes.string' => 'Notes must be valid text.',
            'notes.max' => 'Notes cannot exceed 1000 characters.',
        ];
    }

    /**
     * Clean currency value by removing currency symbols and formatting
     *
     * @param string|null $value
     * @return string|null
     */
    private function cleanCurrencyValue($value)
    {
        if (empty($value)) {
            return null;
        }

        // Remove currency symbols, commas, and spaces
        $cleaned = preg_replace('/[₹$,\s]/', '', $value);

        // Return cleaned value or null if empty
        return $cleaned !== '' ? $cleaned : null;
    }
}