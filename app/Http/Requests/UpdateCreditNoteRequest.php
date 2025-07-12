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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'amount_paid' => 'required|numeric|min:0',
            'amount_spent' => 'required|numeric|min:0',
            'credit_balance' => 'required|numeric',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'customer_name.required' => 'Customer name is required.',
            'customer_name.max' => 'Customer name cannot exceed 255 characters.',
            'amount_paid.required' => 'Amount paid is required.',
            'amount_paid.numeric' => 'Amount paid must be a valid number.',
            'amount_paid.min' => 'Amount paid cannot be negative.',
            'amount_spent.required' => 'Amount spent is required.',
            'amount_spent.numeric' => 'Amount spent must be a valid number.',
            'amount_spent.min' => 'Amount spent cannot be negative.',
            'credit_balance.required' => 'Credit balance is required.',
            'credit_balance.numeric' => 'Credit balance must be a valid number.',
            'notes.max' => 'Notes cannot exceed 1000 characters.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Calculate credit balance if not provided
        if ($this->has('amount_paid') && $this->has('amount_spent') && !$this->has('credit_balance')) {
            $this->merge([
                'credit_balance' => $this->amount_paid - $this->amount_spent
            ]);
        }
    }
}
