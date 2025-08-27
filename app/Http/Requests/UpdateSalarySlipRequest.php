<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSalarySlipRequest extends FormRequest
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
            'employee_name' => 'required|string|max:255',
            'employee_id_number' => 'required|string|max:100',
            'designation' => 'required|string|max:255',
            'period_from' => 'required|date',
            'period_to' => 'required|date|after_or_equal:period_from',
            'generated_date' => 'required|date',
            
            // Payment validation
            'payment_method' => 'required|array',
            'payment_method.*' => 'required|string|max:100',
            'payment_amount' => 'required|array',
            'payment_amount.*' => 'required|numeric|min:0',
            'payment_received_date' => 'required|array',
            'payment_received_date.*' => 'required|date',
            
            // Deduction validation
            'deduction_type' => 'nullable|array',
            'deduction_type.*' => 'required|string|max:100',
            'deduction_description' => 'nullable|array',
            'deduction_description.*' => 'required|string|max:255',
            'deduction_amount' => 'nullable|array',
            'deduction_amount.*' => 'required|numeric|min:0',
            
            // Signature
            'show_signature' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'employee_name.required' => 'Employee name is required.',
            'employee_id_number.required' => 'Employee ID number is required.',
            'designation.required' => 'Designation is required.',
            'period_from.required' => 'Period start date is required.',
            'period_to.required' => 'Period end date is required.',
            'period_to.after_or_equal' => 'Period end date must be after or equal to start date.',
            'generated_date.required' => 'Generated date is required.',
            
            'payment_method.required' => 'At least one payment method is required.',
            'payment_amount.required' => 'Payment amounts are required.',
            'payment_received_date.required' => 'Payment received dates are required.',
            
            'deduction_type.*.required' => 'Deduction type is required.',
            'deduction_description.*.required' => 'Deduction description is required.',
            'deduction_amount.*.required' => 'Deduction amount is required.',
        ];
    }
}
