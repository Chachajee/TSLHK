<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SalarySlip;
use App\Models\SalaryPayment;
use App\Models\SalaryDeduction;
use Carbon\Carbon;

class SalarySlipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample salary slips
        $salarySlips = [
            [
                'employee_name' => 'Mr. Khan, Ozaif',
                'employee_id_number' => 'Y737632(2)',
                'designation' => 'Quality Control Manager',
                'period_from' => '2024-09-01',
                'period_to' => '2024-12-31',
                'generated_date' => '2024-12-31',
                'payments' => [
                    [
                        'payment_method' => 'Autopay',
                        'amount' => 2500.00,
                        'received_date' => '2024-12-31',
                    ],
                    [
                        'payment_method' => 'Cash',
                        'amount' => 500.00,
                        'received_date' => '2024-12-31',
                    ],
                ],
                'deductions' => [
                    [
                        'deduction_type' => 'Tax',
                        'description' => 'Income Tax',
                        'amount' => 300.00,
                    ],
                    [
                        'deduction_type' => 'Insurance',
                        'description' => 'Health Insurance',
                        'amount' => 150.00,
                    ],
                ],
            ],
            [
                'employee_name' => 'Ms. Sarah Johnson',
                'employee_id_number' => 'Y737633(1)',
                'designation' => 'Senior Accountant',
                'period_from' => '2024-10-01',
                'period_to' => '2024-12-31',
                'generated_date' => '2024-12-31',
                'payments' => [
                    [
                        'payment_method' => 'Bank Transfer',
                        'amount' => 3200.00,
                        'received_date' => '2024-12-31',
                    ],
                ],
                'deductions' => [
                    [
                        'deduction_type' => 'Tax',
                        'description' => 'Income Tax',
                        'amount' => 400.00,
                    ],
                    [
                        'deduction_type' => 'Loan',
                        'description' => 'Personal Loan Repayment',
                        'amount' => 200.00,
                    ],
                ],
            ],
            [
                'employee_name' => 'Mr. David Chen',
                'employee_id_number' => 'Y737634(3)',
                'designation' => 'IT Support Specialist',
                'period_from' => '2024-11-01',
                'period_to' => '2024-12-31',
                'generated_date' => '2024-12-31',
                'payments' => [
                    [
                        'payment_method' => 'Check',
                        'amount' => 2800.00,
                        'received_date' => '2024-12-31',
                    ],
                ],
                'deductions' => [
                    [
                        'deduction_type' => 'Tax',
                        'description' => 'Income Tax',
                        'amount' => 350.00,
                    ],
                ],
            ],
        ];

        foreach ($salarySlips as $slipData) {
            $payments = $slipData['payments'];
            $deductions = $slipData['deductions'];
            
            // Remove payments and deductions from slip data
            unset($slipData['payments'], $slipData['deductions']);
            
            $salarySlip = SalarySlip::create($slipData);

            // Create payments
            foreach ($payments as $paymentData) {
                $salarySlip->payments()->create($paymentData);
            }

            // Create deductions
            foreach ($deductions as $deductionData) {
                $salarySlip->deductions()->create($deductionData);
            }
        }
    }
}
